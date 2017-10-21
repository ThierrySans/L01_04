package database;

import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;

public class DatabaseSelect {
  /**
   * Aggregate a list of all students.
   * @param connection
   * @return A ResultSet containing the rows of the STUDENT table
   * @throws SQLException
   */
  public static ResultSet getStudents(Connection connection) throws SQLException {
    Statement statement = connection.createStatement();
    ResultSet results = statement.executeQuery("SELECT * FROM STUDENTS;");
    return results;
  }
  
  /**
   * Aggregate a list of all students with a name that matches.
   * @param name The name to match all students.
   * @param connection
   * @return The rows of STUDENTS with a matching name
   * @throws SQLException
   */
  public static ResultSet getStudents(String name, Connection connection) throws SQLException {
    Statement statement = connection.createStatement();
    ResultSet results = statement.executeQuery("SELECT * FROM STUDENTS WHERE FIRSTNAME LIKE " + name.toUpperCase() + "%;");
    return results;
  }
  
  /**
   * Get the student with a matching id.
   * @param utorId The utorId to match with one/no student.
   * @param connection
   * @return The row of STUDENTS containing the student with the matching id.
   * @throws SQLException
   */
  public static ResultSet getStudent(String utorId, Connection connection) throws SQLException {
    Statement statement = connection.createStatement();
    ResultSet results = statement.executeQuery("SELECT * FROM STUDENTS WHERE ID = " + utorId + ";");
    return results;
  }
  
  /**
   * Aggregate a list of all professors.
   * @param connection
   * @return A ResultSet containing the rows of the PROFESSORS table
   * @throws SQLException
   */
  public static ResultSet getProfessors(Connection connection) throws SQLException {
    Statement statement = connection.createStatement();
    ResultSet results = statement.executeQuery("SELECT * FROM PROFESSORS;");
    return results;
  }
  
  /**
   * Get the professor with a matching id.
   * @param utorId The utorId to match with one/no professor.
   * @param connection
   * @return The row of PROFESSORS containing the professor with the matching id.
   * @throws SQLException
   */
  public static ResultSet getProfessor(String utorId, Connection connection) throws SQLException {
    Statement statement = connection.createStatement();
    ResultSet results = statement.executeQuery("SELECT * FROM PROFESSORS WHERE ID = " + utorId + ";");
    return results;
  }

}
