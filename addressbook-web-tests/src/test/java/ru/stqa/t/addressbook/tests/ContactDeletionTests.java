package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.ContactData;

import java.util.List;

public class ContactDeletionTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        app.goTo().homePage();
        if(app.contact().list().size() == 0) {
            app.contact().create(new ContactData("Ivan", "Ivanov", "i.ivanov", "null1@yandex.ru", "testGroupName_1"), true);
        }
    }

    @Test
    public void testContactDeletion () {

        List<ContactData> before = app.contact().list();
        int index = before.size() - 1;

        app.contact().delete(index);
        app.goTo().homePage();

        List<ContactData> after = app.contact().list();
        Assert.assertEquals(after.size(), before.size() - 1);

        before.remove(index);
        Assert.assertEquals(before, after);
    }

}
