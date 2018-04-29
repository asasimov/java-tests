package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

import java.util.Comparator;
import java.util.List;

public class ContactModificationTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        app.goTo().homePage();
        if(app.contact().list().size() == 0) {
            app.contact().create(new ContactData("Ivan", "Ivanov", "i.ivanov", "null1@yandex.ru", "testGroupName_1"), true);
        }
    }

    @Test
    public  void testContactModification() {

        List<ContactData> before = app.contact().list();
        int index = 0;
        int indexContactEdit = 2;
        ContactData contact = new ContactData(before.get(index).getId(),"Test", "Testov", "t.testov", "null2@yandex.ru", null);

        //app.contact().select(before.size() - 1);
        app.contact().modify(indexContactEdit, contact);

        List<ContactData> after = app.contact().list();
        Assert.assertEquals(after.size(), before.size());

        before.remove(index);
        before.add(contact);

        Comparator<? super  ContactData> byId = (c1, c2) -> Integer.compare(c1.getId(), c2.getId());
        before.sort(byId);
        after.sort(byId);
        Assert.assertEquals(before, after);
    }

}
