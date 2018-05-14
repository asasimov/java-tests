package ru.stqa.t.addressbook.generators;

import com.beust.jcommander.JCommander;
import com.beust.jcommander.Parameter;
import com.beust.jcommander.ParameterException;
import com.thoughtworks.xstream.XStream;
import ru.stqa.t.addressbook.model.ContactData;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.Writer;
import java.util.ArrayList;
import java.util.List;

public class ContactDataGenerator {

    @Parameter(names = "-c", description = "Contact count", required = true)
    public int count;

    @Parameter(names = "-f", description = "Target file", required = true)
    public String file;

    @Parameter(names = "-d", description = "Data format", required = true)
    public String format;


    public static void main(String[] args) throws IOException {
        ContactDataGenerator generator = new ContactDataGenerator();
        JCommander jCommander = new JCommander(generator);
        try {
            jCommander.parse(args);
        } catch (ParameterException ex) {
            jCommander.usage();
            return;
        }
        generator.run();

    }

    private void run() throws IOException {
        List<ContactData> contacts = generateContacts(count);
        if (format.equals("csv")) {
            saveAsCsv(contacts, new File(file));
        } else if (format.equals("xml")) {
            saveAsXml(contacts, new File(file));
        } else {
            System.out.println("Unrecognized format" + format);
        }
    }


    private void saveAsCsv(List<ContactData> contacts, File file) throws IOException {
        try (Writer writer = new FileWriter(file)) {
            for (ContactData contact : contacts) {
                writer.write(String.format("%s;%s;%s;%s;%s;%s\n", contact.getFirstName(), contact.getLastName(), contact.getNickName(),
                        contact.getEmail(), contact.getGroups().iterator().next().getName(), contact.getPhoto().getAbsolutePath()));
            }
        }
    }

    private void saveAsXml(List<ContactData> contacts, File file) throws IOException {
        XStream xstream = new XStream();
        xstream.processAnnotations(ContactData.class);
        String xml = xstream.toXML(contacts);
        try (Writer writer = new FileWriter(file)) {
            writer.write(xml);
        }
    }


    private List<ContactData> generateContacts(int count) {
        List<ContactData> contacts = new ArrayList<ContactData>();
        for (int i=0; i<count; i++) {
            contacts.add(new ContactData().withFirstName(String.format("FirstName %s", i))
                    .withLastName(String.format("LastName %s", i)).withNickName(String.format("NickName %s", i))
                    .withEmail(String.format("test" + "%s" + "@yandex.ru", i))
                    .withAddress("SPb").withHomePhone(String.format("333-22-0%s", i))
                    .withPhoto(new File("src/test/resources/img.png")));
        }
        return contacts;
    }

}