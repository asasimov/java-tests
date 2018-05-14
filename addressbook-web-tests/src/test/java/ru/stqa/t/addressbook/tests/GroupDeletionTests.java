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
        if(app.db().groups().size() == 0) {
            app.goTo().groupPage();
            app.group().create(new GroupData().withName(app.getProperty("g.name")));
        }
    }
    
    @Test
    public void testGroupDeletion() {

        Groups before = app.db().groups();
        GroupData deletedGroup = before.iterator().next();

        app.goTo().groupPage();
        app.group().delete(deletedGroup);

        Assert.assertEquals(app.group().count(), before.size() - 1);
        Groups after = app.db().groups();

        before.remove(deletedGroup);
        assertThat(after, equalTo(before.without(deletedGroup)));

        verifyGroupListInUI();
    }



}
