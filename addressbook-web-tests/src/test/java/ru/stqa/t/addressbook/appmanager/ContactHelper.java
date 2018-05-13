package ru.stqa.t.addressbook.appmanager;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.Select;
import org.testng.Assert;
import ru.stqa.t.addressbook.model.ContactData;
import ru.stqa.t.addressbook.model.Contacts;

import java.util.ArrayList;
import java.util.List;

public class ContactHelper extends HelperBase {

    public ContactHelper(WebDriver wd) {
        super(wd);
    }

    public void returnToContactPage() {
        click(By.linkText("home page"));
    }

    public void fillContactForm(ContactData contactData, boolean creation) {
        type(By.name("firstname"), contactData.getFirstName());
        type(By.name("lastname"), contactData.getLastName());
        type(By.name("nickname"), contactData.getNickName());
        type(By.name("email"), contactData.getEmail());
        /*start*/
        type(By.name("address"), contactData.getAddress());
        type(By.name("home"), contactData.getHomePhone());
        /*end*/
        attach(By.name("photo"), contactData.getPhoto());

        if (creation) {
            new Select(wd.findElement(By.name("new_group"))).selectByVisibleText(contactData.getGroup());
        } else {
            Assert.assertFalse(isElementPresent(By.name("new_group")));
        }

        click(By.xpath("//div[@id='content']/form/input[21]"));
    }


    public void select(int index) {
        wd.findElements(By.name("selected[]")).get(index).click();
    }

    private void selectById(int id) {
        wd.findElement(By.cssSelector("td input[value='"+ id + "']")).click();
    }

    public void confirm() {
        click(By.xpath("//div[@id='content']/form[2]/div[2]/input"));
        wd.switchTo().alert().accept();
    }

    public void selectContactEdit(int index) {
        String selector = "//table[@id='maintable']/tbody/tr[" + index + "]/td[8]/a/img";
        click(By.xpath(selector));
    }

    public void selectContactEditById(int id) {
        String selector = "a[href='edit.php?id=" + id + "']";
        click(By.cssSelector(selector));
    }

    public void submitContactModification() {
        click(By.name("update"));
    }

    public void create(ContactData contact, boolean creation) {
        gotoAddNewContact();
        fillContactForm(contact, creation);
        contactCache = null;
        returnToContactPage();
    }


    public void modify(ContactData contact) {
        selectContactEditById(contact.getId());
        fillContactForm(contact, false);
        submitContactModification();
        contactCache = null;
        returnToContactPage();
    }


    public void delete(ContactData contact) {
        selectById(contact.getId());
        confirm();
        contactCache = null;
    }

    private void gotoAddNewContact() {
        click(By.linkText("add new"));
    }

    public boolean isThereAContact() {
        return isElementPresent(By.name("selected[]"));
    }

    public int count() {
        return wd.findElements(By.name("selected[]")).size();
    }

    public List<ContactData> list() {
        List<ContactData> contacts = new ArrayList<ContactData>();
        List<WebElement> elements = wd.findElements(By.cssSelector("#maintable tr[name='entry']"));
        for (WebElement element : elements) {
            int id = Integer.parseInt(element.findElement(By.cssSelector("td.center input")).getAttribute("value"));
            String firstName = element.findElement(By.xpath("td[3]")).getText();
            String lastName = element.findElement(By.xpath("td[2]")).getText();
            contacts.add(new ContactData().withId(id).withFirstName(firstName).withLastName(lastName).withEmail("null@yandex.ru"));
        }
        return  contacts;
    }

    private Contacts contactCache = null;

    public Contacts all() {
        if (contactCache != null) {
            return new Contacts(contactCache);
        }

        contactCache = new Contacts();
        List<WebElement> elements = wd.findElements(By.cssSelector("#maintable tr[name='entry']"));
        for (WebElement element : elements) {
            int id = Integer.parseInt(element.findElement(By.cssSelector("td.center input")).getAttribute("value"));
            String firstName = element.findElement(By.xpath("td[3]")).getText();
            String lastName = element.findElement(By.xpath("td[2]")).getText();
            String address = element.findElement(By.xpath("td[4]")).getText();
            String allEmails = element.findElement(By.xpath("td[5]")).getText();
            String allPhones = element.findElement(By.xpath("td[6]")).getText();

            contactCache.add(new ContactData().withId(id).withFirstName(firstName).withLastName(lastName).withAddress(address).
                    withAllEmails(allEmails).withAllPhones(allPhones));
        }
        return new Contacts(contactCache);
    }

    public ContactData infoFromEditForm(ContactData contact) {
        selectContactEditById(contact.getId());
        String firstName = wd.findElement(By.name("firstname")).getAttribute("value");
        String lastName = wd.findElement(By.name("lastname")).getAttribute("value");
        String homePhone = wd.findElement(By.name("home")).getAttribute("value");
        String mobilePhone = wd.findElement(By.name("mobile")).getAttribute("value");
        String workPhone = wd.findElement(By.name("work")).getAttribute("value");
        String home2Phone = wd.findElement(By.name("phone2")).getAttribute("value");
        String address = wd.findElement(By.name("address")).getText();
        String email = wd.findElement(By.name("email")).getAttribute("value");
        String email2 = wd.findElement(By.name("email2")).getAttribute("value");
        String email3 = wd.findElement(By.name("email3")).getAttribute("value");

        wd.navigate().back();
        return new ContactData().withId(contact.getId()).withFirstName(firstName).withLastName(lastName).withAddress(address)
                .withHomePhone(homePhone).withMobilePhone(mobilePhone).withWorkPhone(workPhone).withHome2Phone(home2Phone).withEmail(email).withEmail2(email2).withEmail3(email3);
    }
}
