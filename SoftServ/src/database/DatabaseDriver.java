package database;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.sql.Connection;
import java.sql.DriverManager;

import java.sql.Statement;

public class DatabaseDriver {
  
  /**
   * This will connect to existing database, or create it if it's not there.
   * @return the database connection.
   */
  public static Connection connectOrCreateDataBase() {
    Connection connection = null;
    try {
      Class.forName("org.sqlite.JDBC");
      File file = new File("/Users/chengge/Desktop/UofT/CSCC01/L01_04/SoftServ/src/database/homework.db");
      String path = "jdbc:sqlite:" + file.getAbsolutePath();
      System.out.println(path);
      connection = DriverManager.getConnection(path);
      
    } catch (Exception e) {
      System.out.println("Something went wrong with the connection.");
      e.printStackTrace();
    }
    
    return connection;
  }
  
  /**
   * This will initialize the database, or throw a ConnectionFailedException.
   * @param connection the database you'd like to write the tables to.
   * @return the connection you passed in, to allow you to continue.
   * @throws ConnectionFailedException If the tables couldn't be initialized, throw
   */
  protected static Connection initialize(Connection connection) throws ConnectionFailedException {
    if (!initializeDatabase(connection)) {
      throw new ConnectionFailedException();
    }
    return connection;
  }
  
  
  protected static Connection reInitialize() throws ConnectionFailedException {
    if (clearDatabase()) {
      Connection connection = connectOrCreateDataBase();
      return initialize(connection);
    } else {   
      throw new ConnectionFailedException();
    }
  }
  
  /*
   * Inirialize tables
   */
  
  
  private static boolean initializeDatabase(Connection connection) {
    Statement statement = null;
    
    try {
      statement = connection.createStatement();
      
      String sql = "CREATE TABLE STUDENTS " 
          + "(ID TEXT PRIMARY KEY NOT NULL," 
          + "FIRSTNAME TEXT NOT NULL,"
          + "LASTNAME TEXT NOT NULL,"
          + "PASSWORD TEXT NOT NULL)";
      statement.executeUpdate(sql);
      
      sql = "CREATE TABLE PROFESSORS " 
          + "(ID TEXT PRIMARY KEY NOT NULL," 
          + "FIRSTNAME TEXT NOT NULL,"
          + "LASTNAME TEXT NOT NULL,"
          + "PASSWORD TEXT NOT NULL,";
      statement.executeUpdate(sql);
      
      statement.close();
      return true;
      
    } catch (Exception e) {
      e.printStackTrace();
    }
    return false;
  }
  
  private static boolean clearDatabase() {
    Path path = Paths.get("homework.db");
    try {
      Files.deleteIfExists(path);
      return true;
    } catch (IOException e) {
      e.printStackTrace();
    }
    return false;
  }
}
