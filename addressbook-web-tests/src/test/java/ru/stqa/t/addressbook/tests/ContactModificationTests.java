package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;

import java.io.File;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactModificationTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        if(app.db().contacts().size() == 0) {
            app.contact().create(new ContactData()
                    .withFirstName(app.getProperty("c.firstName")).withLastName(app.getProperty("c.lastName"))
                    .withNickName(app.getProperty("c.nickName")).withEmail(app.getProperty("c.email"))
                    .withAddress(app.getProperty("c.address"))
                    .withHomePhone(app.getProperty("c.homePhone")), true);

            app.goTo().homePage();
        }
    }

    @Test
    public  void testContactModification() {

        Contacts before = app.db().contacts();
        ContactData modifiedContact = before.iterator().next();
        ContactData contact = new ContactData()
                .withId(modifiedContact.getId()).withFirstName(app.getProperty("c.m.firstName"))
                .withLastName(app.getProperty("c.m.lastName")).withNickName(app.getProperty("c.m.nickName"))
                .withEmail(app.getProperty("c.m.email")).withAddress(app.getProperty("c.m.address"))
                .withHomePhone(app.getProperty("c.m.homePhone")).withPhoto(new File(app.getProperty("path.contacts.photo")));

        app.contact().modify(contact);

        Assert.assertEquals(app.contact().count(), before.size());
        Contacts after = app.db().contacts();

        before.remove(modifiedContact);
        before.add(contact);

        Assert.assertEquals(before, after);
        assertThat(after, equalTo(before.without(modifiedContact).withAdded(contact)));

        verifyContactListInUI();
    }

}
