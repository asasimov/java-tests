package ru.stqa.t.rest;

import org.testng.annotations.Test;

public class IgnoredTests extends TestBase {

    private int issueId = 10;

    @Test
    public void testIgnored(){
        skipIfNotFixed(issueId);
        System.out.println("Test is started...");
    }
}