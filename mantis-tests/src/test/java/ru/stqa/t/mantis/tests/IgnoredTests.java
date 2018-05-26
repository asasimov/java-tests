package ru.stqa.t.mantis.tests;

import org.testng.annotations.Test;

import javax.xml.rpc.ServiceException;
import java.net.MalformedURLException;
import java.rmi.RemoteException;


public class IgnoredTests extends TestBase {

    private int issueId = 3;

    @Test
    public void testIgnored() throws RemoteException, ServiceException, MalformedURLException {
        skipIfNotFixed(issueId);
        System.out.println("Test is started...");
    }

}