package ru.stqa.t.addressbook.tests;

import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;
import ru.stqa.t.addressbook.model.GroupData;
import ru.stqa.t.addressbook.model.Groups;

import java.io.File;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactAddToGroupTest extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        if(app.db().groups().size() == 0) {
            app.goTo().groupPage();
            app.group().create(new GroupData().withName(app.getProperty("g.name")));
        }
        if(app.db().contacts().size() == 0) {
            app.goTo().homePage();
            app.contact().create(new ContactData()
                    .withFirstName(app.getProperty("c.firstName")).withLastName(app.getProperty("c.lastName"))
                    .withNickName(app.getProperty("c.nickName")).withEmail(app.getProperty("c.email"))
                    .withAddress(app.getProperty("c.address"))
                    .withPhoto(new File(app.getProperty("path.contacts.photo"))), true);
        }
    }

    @Test
    public void testContactAddToGroup() {
        Groups groups = app.db().groups();
        Contacts contacts = app.db().contacts();

        ContactData contact = null;
        for (ContactData c : contacts) {
            if(c.getGroups().size() < groups.size()) {
                contact = new ContactData().withId(c.getId()).withLastName(c.getLastName())
                        .withFirstName(c.getFirstName()).withEmail(c.getEmail()).withAddress(c.getAddress())
                        .withPhoto(c.getPhoto()).withNickName(c.getNickName());
                break;
            }
        }
        //создаём новый контакт, если не нашли подходящий
        if (contact == null) {
            app.goTo().homePage();
            ContactData newContact = new ContactData()
                    .withFirstName(app.getProperty("c.firstName")).withLastName(app.getProperty("c.lastName"))
                    .withNickName(app.getProperty("c.nickName")).withEmail(app.getProperty("c.email"))
                    .withAddress(app.getProperty("c.address"))
                    .withPhoto(new File(app.getProperty("path.contacts.photo")));
            app.contact().create(newContact, true);

            //получаем id созданного контакта
            int newContactId = app.db().contacts().stream().mapToInt((c) -> c.getId()).max().getAsInt();
            newContact.withId(newContactId);
            GroupData group = groups.stream().iterator().next();

            app.contact().addToGroup(newContact.getId(), group.getId());

            ContactData contactInDb = app.db().contactInGroups(newContactId);
            assertThat(contactInDb.getGroups(), equalTo(newContact.inGroup(group).getGroups()));
        } else {
            ContactData beforeContact = app.db().contactInGroups(contact.getId());
            groups.removeAll(beforeContact.getGroups());
            GroupData group = groups.stream().iterator().next();

            app.contact().addToGroup(beforeContact.getId(), group.getId());

            ContactData contactInDb = app.db().contactInGroups(contact.getId());
            assertThat(beforeContact.inGroup(group).getGroups(), equalTo(contactInDb.getGroups()));
        }
    }
}
