package ru.stqa.t.mantis.appmanager;

import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;

public class SessionHelper extends HelperBase {

    public SessionHelper(ApplicationManager app) {
        super(app);
    }

    public void login(String username, String password) {
        wd.get(app.getProperty("web.baseUrl") + "/login_page.php");
        type(By.name("username"),username);
        click(By.cssSelector("input[type='submit']"));
        type(By.name("password"),password);
        click(By.cssSelector("input[type='submit']"));
        checkUserLogged(username);
    }

    private void checkUserLogged(String username) {
        WebElement element = wd.findElement(By.cssSelector("span[class='user-info']"));
        element.getText().equals(username);
    }

}