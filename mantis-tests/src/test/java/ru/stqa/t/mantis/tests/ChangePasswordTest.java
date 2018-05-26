package ru.stqa.t.mantis.tests;

import org.testng.annotations.Test;
import ru.stqa.t.mantis.appmanager.HttpSession;
import ru.stqa.t.mantis.model.MailMessage;
import ru.stqa.t.mantis.model.UserData;

import javax.mail.MessagingException;
import java.io.IOException;
import java.util.List;

import static org.testng.Assert.assertTrue;


public class ChangePasswordTest extends TestBase {


    @Test
    public void testChangePassword() throws IOException, MessagingException {
        HttpSession session = app.newSession();
        String newPassword = "newPas$word1";
        app.session().login(app.getProperty("web.adminLogin"), app.getProperty("web.adminPassword"));
        app.resetPassword().goToManagePage();
        UserData user = app.db().user();
        app.resetPassword().changePasswordStart(user.getUsername());
        List<MailMessage> mailMessages = app.mail().waitForMail(1, 30000);
        String resetPasswordLink = app.mail().findMailLink(mailMessages, user.getEmail());
        app.resetPassword().changePasswordFinish(resetPasswordLink, newPassword);

        assertTrue(session.login(user.getUsername(), newPassword));
        assertTrue(session.isLoggedInAs(user.getUsername()));
    }

}