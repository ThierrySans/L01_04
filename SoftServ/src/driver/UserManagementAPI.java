/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package driver;

import database.DatabaseInsert;
import database.DatabaseInsertException;
import database.DatabaseSelect;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;

/**
 *
 * @author fideslinga
 */

public class UserManagementAPI {
    
    public static Connection connection;
       
    public static  int insertStudent(String utorId, String firstName, String lastName) throws DatabaseInsertException {
        return DatabaseInsert.insertStudent(utorId, firstName, lastName, connection);
    }
    public static int insertProfessor(String utorId, String firstName, String lastName) throws DatabaseInsertException{
        return DatabaseInsert.insertProfessor(utorId, firstName, lastName, connection);
    }
    public static ResultSet getStudents() throws SQLException {
        return DatabaseSelect.getStudents(connection);
    }
    public static ResultSet getStudents(String name) throws SQLException {
        return DatabaseSelect.getStudents(name, connection);
    }
    public static ResultSet getStudent(String utorId) throws SQLException {
        return DatabaseSelect.getStudent(utorId, connection);
    }
    public static ResultSet getProfessors() throws SQLException {
        return DatabaseSelect.getProfessors(connection);
    }
    public static ResultSet getProfessor(String utorId) throws SQLException {
        return DatabaseSelect.getProfessor(utorId, connection);
    }
    
}
