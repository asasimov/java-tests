package ru.stqa.t.mantis.appmanager;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.boot.MetadataSources;
import org.hibernate.boot.registry.StandardServiceRegistry;
import org.hibernate.boot.registry.StandardServiceRegistryBuilder;
import ru.stqa.t.mantis.model.UserData;

public class DbHelper {

    private final SessionFactory sessionFactory;

    public DbHelper() {
        final StandardServiceRegistry registry = new StandardServiceRegistryBuilder()
                .configure() // configures settings from hibernate.cfg.xml
                .build();
        sessionFactory = new MetadataSources(registry).buildMetadata().buildSessionFactory();
    }

    public UserData user() {
        Session session = sessionFactory.openSession();
        session.beginTransaction();
        UserData us = (UserData) session.createQuery( "from UserData where id != 1").stream().iterator().next();
        session.getTransaction().commit();
        session.close();
        return new UserData().withId(us.getId()).withUsername(us.getUsername()).withEmail(us.getEmail());
    }
}
