package ru.stqa.t.addressbook.tests;

import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

public class ContactCreationTests extends TestBase {


    @Test
    public void testContactCreation() {
        app.gotoAddNewContact();
        app.fillContactForm(new ContactData("Aleksandr", "Sasimov", "asasimov", "a.sasimov@yandex.ru"));
        app.returnToContactPage();
    }

}
