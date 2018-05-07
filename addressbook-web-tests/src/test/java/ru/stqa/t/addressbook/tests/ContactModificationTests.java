package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactModificationTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        app.goTo().homePage();
        if(app.contact().list().size() == 0) {
            app.contact().create(new ContactData()
                    .withFirstName(app.getProperty("c.firstName")).withLastName(app.getProperty("c.lastName"))
                    .withNickName(app.getProperty("c.nickName")).withEmail(app.getProperty("c.email"))
                    .withGroup(app.getProperty("c.group")), true);
        }
    }

    @Test
    public  void testContactModification() {

        Contacts before = app.contact().all();
        ContactData modifiedContact = before.iterator().next();
        ContactData contact = new ContactData()
                .withId(modifiedContact.getId()).withFirstName(app.getProperty("c.m.firstName"))
                .withLastName(app.getProperty("c.m.lastName")).withNickName(app.getProperty("c.m.nickName"))
                .withEmail(app.getProperty("c.m.email"));

        app.contact().modify(contact);

        Assert.assertEquals(app.contact().count(), before.size());
        Contacts after = app.contact().all();

        before.remove(modifiedContact);
        before.add(contact);

        Assert.assertEquals(before, after);
        assertThat(after, equalTo(before.without(modifiedContact).withAdded(contact)));
    }

}
