package ru.stqa.t.addressbook.tests;

import org.testng.Assert;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import ru.stqa.t.addressbook.model.GroupData;
import ru.stqa.t.addressbook.model.Groups;

import static org.hamcrest.CoreMatchers.*;
import static org.hamcrest.MatcherAssert.*;

public class GroupModificationTests extends TestBase {

    @BeforeMethod
    public void ensurePreconditions() {
        app.goTo().groupPage();
        if(app.group().list().size() == 0) {
            app.group().create(new GroupData().withName("testGroupName_1"));
        }
    }

    @Test
    public void testGroupModification() {

        Groups before = app.group().all();
        GroupData modifiedGroup = before.iterator().next();
        GroupData group = new GroupData()
                .withId(modifiedGroup.getId()).withName("Test_name").withHeader("Test_header").withFooter("Test_footer");

        app.group().modify(group);

        Assert.assertEquals(app.group().count(), before.size());
        Groups after = app.group().all();

        before.remove(modifiedGroup);
        before.add(group);

        assertThat(after, equalTo(before.without(modifiedGroup).withAdded(group)));

    }

}
