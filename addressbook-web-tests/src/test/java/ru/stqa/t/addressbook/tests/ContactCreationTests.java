package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.GroupData;

import java.util.List;

public class ContactCreationTests extends TestBase {


    @Test
    public void testContactCreation() {

        //int before = app.getContactHelper().getContactCount();
        List<ContactData> before = app.getContactHelper().getContactList();

        app.getContactHelper().createContact(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru", "testGroupName_1"), true);

        //int after = app.getContactHelper().getContactCount();
        List<ContactData> after = app.getContactHelper().getContactList();
        Assert.assertEquals(after.size(), before.size() + 1);

    }

}
