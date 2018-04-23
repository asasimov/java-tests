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
            app.getContactHelper().createContact(new ContactData("Aleksandr", "Sasimov", "asasimov", "null@yandex.ru", "testGroupName_1"), true);
        }

        List<ContactData> before = app.getContactHelper().getContactList();

        app.getContactHelper().selectContact(before.size() - 1);
        app.getContactHelper().selectEditContact();
        ContactData contact = new ContactData(before.get(before.size() - 1).getId(),"Test", "Testov", "asasimov", "null@yandex.ru", null);
        app.getContactHelper().fillContactForm(contact, false);
        app.getContactHelper().submitContactModification();
        app.getContactHelper().returnToContactPage();

        List<ContactData> after = app.getContactHelper().getContactList();
        Assert.assertEquals(after.size(), before.size());

        //так как для редактирования берется первая стока из таблицы, удаляем элемент с index=0
        before.remove(0);
        before.add(contact);

        Comparator<? super  ContactData> byId = (c1, c2) -> Integer.compare(c1.getId(), c2.getId());
        before.sort(byId);
        after.sort(byId);
        Assert.assertEquals(before, after);
    }
}
