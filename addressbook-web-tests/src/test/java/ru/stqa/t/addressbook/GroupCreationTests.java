package ru.stqa.t.addressbook;

import org.testng.annotations.Test;

public class GroupCreationTests extends TestBase {

    @Test
    public void testGroupCreation() {
        gotoGroupPage();
        initGroupCreation();
        fillGroupForm(new GroupData("testGroupName", "testGroupHeader", "testGroupFooter"));
        submitGroupCreation();
        returnToGroupPage();
    }

}
