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
        if(app.db().groups().size() == 0) {
            app.goTo().groupPage();
            app.group().create(new GroupData().withName(app.getProperty("g.name")));
        }
    }

    @Test
    public void testGroupModification() {

        Groups before = app.db().groups();
        GroupData modifiedGroup = before.iterator().next();
        GroupData group = new GroupData()
                .withId(modifiedGroup.getId()).withName(app.getProperty("g.m.name"))
                .withHeader(app.getProperty("g.m.header")).withFooter(app.getProperty("g.m.footer"));

        app.goTo().groupPage();
        app.group().modify(group);

        Assert.assertEquals(app.group().count(), before.size());
        Groups after = app.db().groups();

        before.remove(modifiedGroup);
        before.add(group);

        assertThat(after, equalTo(before.without(modifiedGroup).withAdded(group)));

        verifyGroupListInUI();
    }

}
