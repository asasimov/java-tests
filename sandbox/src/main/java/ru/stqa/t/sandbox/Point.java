package ru.stqa.t.sandbox;

public class Point {

    double x;
    double y;

    public Point(double x, double y) {
        this.x = x;
        this.y = y;
    }

    public static double distance(Point p1, Point p2) {
        double x1 = p1.x;
        double y1 = p1.y;
        double x2 = p2.x;
        double y2 = p2.y;

        double a = ((x2 - x1)*(x2 - x1));
        double b = ((y2 - y1)*(y2 - y1));
        double z = a + b;
        double res = Math.sqrt(z);

        return res;
    }
}
