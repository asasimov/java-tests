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
                    .withFirstName("Ivan").withLastName("Ivanov").withNickName("i.ivanov").withEmail("null1@yandex.ru").withGroup("testGroupName_1"), true);
        }
    }

    @Test
    public  void testContactModification() {

        Contacts before = app.contact().all();
        ContactData modifiedContact = before.iterator().next();
        ContactData contact = new ContactData()
                .withId(modifiedContact.getId()).withFirstName("Test").withLastName("Testov").withNickName("t.testov").withEmail("null2@yandex.ru");

        app.contact().modify(contact);

        Assert.assertEquals(app.contact().count(), before.size());
        Contacts after = app.contact().all();

        before.remove(modifiedContact);
        before.add(contact);

        Assert.assertEquals(before, after);
        assertThat(after, equalTo(before.without(modifiedContact).withAdded(contact)));
    }

}
