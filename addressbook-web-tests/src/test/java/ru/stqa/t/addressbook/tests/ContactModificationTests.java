package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

import java.util.List;

public class ContactModificationTests extends TestBase {

    @Test
    public  void testContactModification() {
        app.getNavigationHelper().gotoHomePage();

        if(! app.getContactHelper().isThereAContact()) {
            app.getContactHelper().createContact(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru", "testGroupName_1"), true);
        }

        List<ContactData> before = app.getContactHelper().getContactList();

        app.getContactHelper().selectContact(before.size() - 1);
        app.getContactHelper().selectEditContact();
        app.getContactHelper().fillContactForm(new ContactData("Test", "Testov", "asasimov", "null@yandex.ru", null), false);
        app.getContactHelper().submitContactModification();
        app.getContactHelper().returnToContactPage();

        List<ContactData> after = app.getContactHelper().getContactList();
        Assert.assertEquals(after.size(), before.size());
    }
}
