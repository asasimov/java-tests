package ru.stqa.t.addressbook.tests;

import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

import java.util.Arrays;
import java.util.stream.Collectors;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactInfoTests extends TestBase {

    @BeforeMethod
    public void ensurePrecondition() {
        if (app.db().contacts().size() == 0) {
            app.contact().create(new ContactData().withFirstName(app.getProperty("c.firstName"))
                    .withLastName(app.getProperty("c.firstName")).withNickName(app.getProperty("c.nickName"))
                    .withEmail(app.getProperty("c.email")).withAddress(app.getProperty("c.address"))
                    .withHomePhone(app.getProperty("c.homePhone")).withGroup(app.getProperty("c.group")), true);
            app.goTo().homePage();
        }
    }

    @Test
    public void testInfoContact() {
        app.goTo().homePage();
        ContactData contact = app.contact().all().iterator().next();
        ContactData contactInfoFromEditForm = app.contact().infoFromEditForm(contact);

        assertThat(contact.getAddress(), equalTo(contactInfoFromEditForm.getAddress()));
        assertThat(contact.getAllPhones(), equalTo(mergePhones(contactInfoFromEditForm)));
        assertThat(contact.getAllEmails(), equalTo(mergeEmails(contactInfoFromEditForm)));
    }

    private String mergePhones(ContactData contact) {
        return Arrays.asList(contact.getHomePhone(), contact.getMobilePhone(), contact.getWorkPhone(), contact.getHome2Phone()).stream().filter((s) -> !s.equals("")).
                map(ContactInfoTests::cleaned).collect(Collectors.joining("\n"));
    }

    public static String cleaned(String phone) {
        return phone.replaceAll("\\s", "").replaceAll("[-()]", "");
    }

    private String mergeEmails(ContactData contact) {
        return Arrays.asList(contact.getEmail(), contact.getEmail2(), contact.getEmail3()).
                stream().filter((s) -> !s.equals("")).collect(Collectors.joining("\n"));
    }
}
