package ru.stqa.t.sandbox;

public class MyFirstClass {

        public static void main(String[] args){
            System.out.println("Hello!");

            Point p1 = new Point(1,2);
            Point p2 = new Point(7,9);

            System.out.println(Point.distance(p1, p2));
        }
}