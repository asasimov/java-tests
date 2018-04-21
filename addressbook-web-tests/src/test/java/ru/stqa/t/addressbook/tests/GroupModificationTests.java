package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.GroupData;

import java.util.List;

public class GroupModificationTests extends TestBase {

    @Test
    public void testGroupModification() {
        app.getNavigationHelper().gotoGroupPage();

        if(! app.getGroupHelper().isThereAGroup()) {
            app.getGroupHelper().createGroup(new GroupData("testGroupName_1", null, null));
        }

        List<GroupData> before = app.getGroupHelper().getGroupList();

        app.getGroupHelper().selectGroup(before.size() - 1);
        app.getGroupHelper().initGroupModification();
        app.getGroupHelper().fillGroupForm(new GroupData("Test_name", "Test_header", "Test_footer"));
        app.getGroupHelper().submitGroupModification();
        app.getGroupHelper().returnToGroupPage();

        List<GroupData> after = app.getGroupHelper().getGroupList();
        Assert.assertEquals(after.size(), before.size());
    }
}
