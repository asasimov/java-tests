package ru.stqa.t.addressbook.model;

public class ContactData {
    private final String firstName;
    private final String lastName;
    private final String nickName;
    private final String email;

    public ContactData(String firstName, String lastName, String nickName, String email) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.nickName = nickName;
        this.email = email;
    }

    public String getFirstName() {
        return firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public String getNickName() {
        return nickName;
    }

    public String getEmail() {
        return email;
    }
}
