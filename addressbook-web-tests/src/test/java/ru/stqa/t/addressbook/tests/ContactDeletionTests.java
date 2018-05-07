package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;

public class ContactDeletionTests extends TestBase {

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
    public void testContactDeletion () {

        Contacts before = app.contact().all();
        ContactData deletedContact = before.iterator().next();

        app.contact().delete(deletedContact);
        app.goTo().homePage();

        Assert.assertEquals(app.contact().count(), before.size() - 1);
        Contacts after = app.contact().all();

        before.remove(deletedContact);
        assertThat(after, equalTo(before.without(deletedContact)));
    }

}
