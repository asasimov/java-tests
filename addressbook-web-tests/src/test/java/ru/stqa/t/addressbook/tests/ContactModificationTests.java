package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

public class ContactModificationTests extends TestBase {

    @Test
    public  void testContactModification() {
        app.getNavigationHelper().gotoHomePage();

       int before = app.getContactHelper().getContactCount();

        if(! app.getContactHelper().isThereAContact()) {
            app.getContactHelper().createContact(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru", "testGroupName_1"), true);
        }

        app.getContactHelper().selectContact();
        app.getContactHelper().selectEditContact();
        app.getContactHelper().fillContactForm(new ContactData("Test", "Testov", "asasimov", "null@yandex.ru", null), false);
        app.getContactHelper().submitContactModification();
        app.getContactHelper().returnToContactPage();

        int after = app.getContactHelper().getContactCount();
        Assert.assertEquals(after, before);
    }
}
