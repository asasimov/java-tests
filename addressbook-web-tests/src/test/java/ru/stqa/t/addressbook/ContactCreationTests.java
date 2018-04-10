package ru.stqa.t.addressbook;

import org.testng.annotations.Test;

public class ContactCreationTests extends TestBase {


    @Test
    public void testContactCreation() {
        gotoAddNewContact();
        fillContactForm(new ContactData("Aleksandr", "Sasimov", "asasimov", "a.sasimov@yandex.ru"));
        returnToContactPage();
    }

}
