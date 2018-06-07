package ru.stqa.t.addressbook.tests;

import io.qameta.allure.Description;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;
import ru.stqa.t.addressbook.model.GroupData;
import ru.stqa.t.addressbook.model.Groups;

import java.io.File;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactRemoveGroupTest extends TestBase {

    @BeforeMethod
    @Description(value = "Описание BeforeMethod")
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
                    .withPhoto(new File(app.getProperty("path.contacts.photo")))
                    .inGroup(app.db().groups().iterator().next()), true);
        }
    }

    @Test(description = "Описание тестового метода")
    public void testContactRemoveGroup() {
        app.goTo().homePage();
        Groups groups = app.db().groups();
        Contacts contacts = app.db().contacts();

        int contact_id = 0;
        Groups contactGroups = null;
        for (ContactData c : contacts) {
            if(c.getGroups().size() > 0) {
               contact_id = c.getId();
               contactGroups = c.getGroups();
               break;
            }
        }

        if (contact_id == 0) {
            ContactData newContact = new ContactData()
                    .withFirstName(app.getProperty("c.firstName")).withLastName(app.getProperty("c.lastName"))
                    .withNickName(app.getProperty("c.nickName")).withEmail(app.getProperty("c.email"))
                    .withAddress(app.getProperty("c.address"))
                    .withPhoto(new File(app.getProperty("path.contacts.photo")))
                    .inGroup(app.db().groups().iterator().next());
            app.contact().create(newContact, true);

            int newContactId = app.db().contacts().stream().mapToInt((c) -> c.getId()).max().getAsInt();
            newContact.withId(newContactId);
            GroupData group = newContact.getGroups().stream().iterator().next();
            app.contact().removeFromGroup(newContact.getId(), group.getId());
            ContactData contactInDb = app.db().contactInGroups(newContact.getId());
            assertThat(newContact.getGroups().without(group), equalTo(contactInDb.getGroups()));
        } else {
            GroupData group = contactGroups.iterator().next();
            app.contact().removeFromGroup(contact_id, group.getId());
            ContactData contactInDb = app.db().contactInGroups(contact_id);
            assertThat(contactGroups.without(group), equalTo(contactInDb.getGroups()));
        }
    }
}
