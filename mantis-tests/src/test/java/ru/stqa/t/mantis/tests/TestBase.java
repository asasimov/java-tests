package ru.stqa.t.mantis.tests;

import biz.futureware.mantis.rpc.soap.client.IssueData;
import biz.futureware.mantis.rpc.soap.client.MantisConnectPortType;
import org.openqa.selenium.remote.BrowserType;
import org.testng.SkipException;
import org.testng.annotations.AfterSuite;
import org.testng.annotations.BeforeSuite;
import javax.xml.rpc.ServiceException;

import ru.stqa.t.mantis.appmanager.ApplicationManager;

import java.io.File;
import java.io.IOException;
import java.math.BigInteger;
import java.net.MalformedURLException;
import java.rmi.RemoteException;

public class TestBase {

    protected static final ApplicationManager app = new ApplicationManager(System.getProperty("browser", BrowserType.CHROME));

    @BeforeSuite
    public void setUp() throws Exception {
        app.mail().start();
        app.init();
        app.ftp().upload(new File(app.getProperty("mantis.config")), app.getProperty("mantis.target"), app.getProperty("mantis.backup"));
    }

    @AfterSuite(alwaysRun = true)
    public void tearDown() throws IOException {
        app.ftp().restore(app.getProperty("mantis.backup"), app.getProperty("mantis.target"));
        app.stop();
        app.mail().stop();
    }

    public void skipIfNotFixed(int issueId) throws MalformedURLException,  RemoteException, ServiceException {
        if (isIssueOpen(issueId)) {
            System.out.println("Ignored because of issue " + issueId);
            throw new SkipException("Ignored because of issue " + issueId);
        }
    }

    private boolean isIssueOpen(int issueId) throws MalformedURLException, RemoteException, ServiceException {
        MantisConnectPortType mc = app.soap().getMantisConnect();
        IssueData issueData = mc.mc_issue_get(app.getProperty("web.adminLogin"), app.getProperty("web.adminPassword"), BigInteger.valueOf(issueId));
        int status = issueData.getStatus().getId().intValue();
        if (status == 80 || status == 90) {
            return false;
        } else {
            return true;
        }
    }
}
