package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.GroupData;
import ru.stqa.t.addressbook.model.Groups;

import static org.hamcrest.CoreMatchers.*;
import static org.hamcrest.MatcherAssert.*;

public class GroupDeletionTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        app.goTo().groupPage();
        if(app.group().list().size() == 0) {
            app.group().create(new GroupData().withName("testGroupName_1"));
        }
    }
    
    @Test
    public void testGroupDeletion() {

        Groups before = app.group().all();
        GroupData deletedGroup = before.iterator().next();

        app.group().delete(deletedGroup);

        Groups after = app.group().all();
        Assert.assertEquals(after.size(), before.size() - 1);

        before.remove(deletedGroup);
        assertThat(after, equalTo(before.without(deletedGroup)));
    }



}
