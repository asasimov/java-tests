package ru.stqa.t.sandbox;

import org.testng.Assert;
import org.testng.annotations.Test;

public class TestPoint {

    @Test
    public void testsPoint() {
        Point p1 = new Point(1,2);
        Point p2 = new Point(5,8);
        Assert.assertEquals(p1.distance(p2), 2.8284271247462);
    }
}
