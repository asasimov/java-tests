package ru.stqa.t.sandbox;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class Collections {

    public static void main(String[] args) {

        String[] langs = {"Java", "C#", "Python", "PHP" };

        /* List<String> languages = new ArrayList<String>();
        languages.add("Java");
        languages.add("C#");
        languages.add("Python");
        languages.add("PHP"); */
        List<String> languages = Arrays.asList("Java", "C#", "Python", "PHP");

        for (String l : languages) {
            System.out.println(l);
        }

        System.out.println("---");

        for (int i = 0; languages.size() > i; i++) {
            System.out.println(languages.get(i));
        }

    }
}
