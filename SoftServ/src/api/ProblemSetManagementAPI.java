/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package api;

import database.DatabaseDriver;
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
public class ProblemSetManagementAPI {
    
    public static Connection connection =  DatabaseDriver.connectOrCreateDataBase();
    
    public static  int insertUnit(String unitID, String unitName) throws DatabaseInsertException {
        return DatabaseInsert.insertUnit(unitID, unitName, connection);
    }
    public static ResultSet getUnit(String unitID) throws SQLException {
        return DatabaseSelect.getUnit(unitID, connection);
    }
    public static ResultSet getUnits(String unitName) throws SQLException {
        return DatabaseSelect.getUnits(unitName, connection);
    }
    public static ResultSet getUnits() throws SQLException {
        return DatabaseSelect.getUnits(connection);
    }
    
}
