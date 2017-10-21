package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;

public class DatabaseInsert {
  /**
   * Insert a new student into the STUDENTS table.
   * @param utorId The utorId of a student.
   * @param firstName The first name of a student.
   * @param lastName The first name of a student.
   * @param connection
   * @return An integer > 0 to verify a student was added.
     * @throws database.DatabaseInsertException
   * @throws DatabaseInsertException
   */
  public static  int insertStudent(String utorId, String firstName, String lastName, String password, Connection connection) throws DatabaseInsertException {
    String sql = "INSERT INTO STUDENTS(STUDENTID, FIRSTNAME, LASTNAME, PASSWORD) VALUES(?,?,?,?)";
    try {
      PreparedStatement preparedStatement = connection.prepareStatement(sql, 
                                              Statement.RETURN_GENERATED_KEYS);
      preparedStatement.setString(1,utorId);
      preparedStatement.setString(2, firstName);
      preparedStatement.setString(3, lastName);
      preparedStatement.setString(4, password);
      int id = preparedStatement.executeUpdate();
      if (id > 0) {
        ResultSet uniqueKey = preparedStatement.getGeneratedKeys();
        if (uniqueKey.next()) {
          return uniqueKey.getInt(1);
        }
      }
    } catch (Exception e) {
      e.printStackTrace();
    }
    throw new DatabaseInsertException();
  }

  /**
   * Insert a professor into the PROFESSORS table.
   * @param utorId The utorID of a professor.
   * @param firstName The first name of a professor.
   * @param lastName The first name of a professor.
   * @param connection
   * @return An integer > 0 to represent a successful new row.
   * @throws DatabaseInsertException
   */
  public static int insertProfessor(String utorId, String firstName, String lastName, String password, Connection connection) throws DatabaseInsertException{
    String sql = "INSERT INTO PROFESSORS(ID, FIRSTNAME, LASTNAME, PASSWORD) VALUES(?,?,?,?)";
    try {
      PreparedStatement preparedStatement = connection.prepareStatement(sql, 
                                              Statement.RETURN_GENERATED_KEYS);
      preparedStatement.setString(1,utorId);
      preparedStatement.setString(2, firstName);
      preparedStatement.setString(3, lastName);
      preparedStatement.setString(4, password);
      int id = preparedStatement.executeUpdate();
      if (id > 0) {
        ResultSet uniqueKey = preparedStatement.getGeneratedKeys();
        if (uniqueKey.next()) {
          return uniqueKey.getInt(1);
        }
      }
    } catch (Exception e) {
      e.printStackTrace();
    }
    throw new DatabaseInsertException();
  }
  
  
}
