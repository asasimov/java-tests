package ru.stqa.t.mantis.appmanager;

import org.openqa.selenium.By;

public class ResetPasswordHelper extends HelperBase {

    public ResetPasswordHelper(ApplicationManager app) {
        super(app);
    }

    public void goToManagePage(){
        wd.findElement(By.linkText("управление")).click();
    }

    public void changePasswordStart(String username){
        wd.findElement(By.cssSelector("a[href=\"/mantisbt/manage_user_page.php\"]")).click();
        wd.findElement(By.linkText(username)).click();
        wd.findElement(By.xpath("//form[@id='manage-user-reset-form']/fieldset/span/input")).click();
    }


    public void changePasswordFinish(String resetPasswordLink, String newpassword){
        wd.get(resetPasswordLink);
        type(By.name("password"),newpassword);
        type(By.name("password_confirm"),newpassword);
        click(By.cssSelector("span[class='bigger-110']"));
    }

}

