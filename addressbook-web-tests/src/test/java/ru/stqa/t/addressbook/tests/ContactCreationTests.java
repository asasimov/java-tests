package ru.stqa.t.addressbook.tests;

import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

public class ContactCreationTests extends TestBase {


    @Test
    public void testContactCreation() {
        app.getNavigationHelper().gotoAddNewContact();
        app.getContactHelper().fillContactForm(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru"));
        app.getContactHelper().returnToContactPage();
    }

}
