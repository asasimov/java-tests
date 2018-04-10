package ru.stqa.t.addressbook.tests;

import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.GroupData;

public class GroupCreationTests extends TestBase {

    @Test
    public void testGroupCreation() {
        app.gotoGroupPage();
        app.initGroupCreation();
        app.fillGroupForm(new GroupData("testGroupName", "testGroupHeader", "testGroupFooter"));
        app.submitGroupCreation();
        app.returnToGroupPage();
    }

}
