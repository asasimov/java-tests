package ru.stqa.t.mantis.tests;

import org.testng.annotations.Test;
import ru.stqa.t.mantis.appmanager.HttpSession;
import ru.stqa.t.mantis.model.MailMessage;

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
        String username = app.db().user().getUsername();
        String email = app.db().user().getEmail();
        app.resetPassword().changePasswordStart(username);
        List<MailMessage> mailMessages = app.mail().waitForMail(1, 30000);
        String resetPasswordLink = app.mail().findMailLink(mailMessages, email);
        app.resetPassword().changePasswordFinish(resetPasswordLink, newPassword);

        assertTrue(session.login(username, newPassword));
        assertTrue(session.isLoggedInAs(username));
    }

}