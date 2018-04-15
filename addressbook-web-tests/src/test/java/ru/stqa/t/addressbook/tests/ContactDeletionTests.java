package ru.stqa.t.addressbook.tests;

import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

public class ContactDeletionTests extends TestBase {

    @Test
    public void testContactDeletion () {
        app.getNavigationHelper().gotoHomePage();

        if(! app.getContactHelper().isThereAContact()) {
            app.getContactHelper().createContact(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru", "testGroupName_1"), true);

        }

        app.getContactHelper().selectContact();
        app.getContactHelper().confirmDeletion();
    }
}
