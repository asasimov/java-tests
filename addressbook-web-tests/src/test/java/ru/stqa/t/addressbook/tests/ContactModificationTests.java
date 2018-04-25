package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

import java.util.Comparator;
import java.util.List;

public class ContactModificationTests extends TestBase {

    @Test
    public  void testContactModification() {
        app.getNavigationHelper().gotoHomePage();

        if(! app.getContactHelper().isThereAContact()) {
            app.getContactHelper().createContact(new ContactData("Ivan", "Ivanov", "i.ivanov", "null1@yandex.ru", "testGroupName_1"), true);
        }

        List<ContactData> before = app.getContactHelper().getContactList();

        //app.getContactHelper().selectContact(before.size() - 1);
        app.getContactHelper().selectContactEdit(2);
        ContactData contact = new ContactData(before.get(0).getId(),"Test", "Testov", "t.testov", "null2@yandex.ru", null);
        app.getContactHelper().fillContactForm(contact, false);
        app.getContactHelper().submitContactModification();
        app.getContactHelper().returnToContactPage();

        List<ContactData> after = app.getContactHelper().getContactList();
        Assert.assertEquals(after.size(), before.size());

        before.remove(0);
        before.add(contact);

        Comparator<? super  ContactData> byId = (c1, c2) -> Integer.compare(c1.getId(), c2.getId());
        before.sort(byId);
        after.sort(byId);
        Assert.assertEquals(before, after);
    }
}
