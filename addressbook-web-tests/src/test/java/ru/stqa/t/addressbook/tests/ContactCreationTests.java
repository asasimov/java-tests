package ru.stqa.t.addressbook.tests;

import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;

import static org.hamcrest.CoreMatchers.equalTo;
import static org.hamcrest.MatcherAssert.assertThat;


public class ContactCreationTests extends TestBase {


    @Test
    public void testContactCreation() {

        Contacts before = app.contact().all();

        ContactData contact = new ContactData()
                .withFirstName("Ivan").withLastName("Ivanov").withNickName("i.ivanov").withEmail("null1@yandex.ru").withGroup("testGroupName_1");
        app.contact().create(contact, true);

        Contacts after = app.contact().all();
        assertThat(after.size(), equalTo(before.size() + 1));

        assertThat(after, equalTo(before.withAdded(contact.withId(after.stream().mapToInt((c) -> c.getId()).max().getAsInt()))));
    }

}
