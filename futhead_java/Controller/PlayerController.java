package Controller;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.Statement;
import java.util.ArrayList;
import Model.player;

public class PlayerController {
	public static ArrayList<player> list = Process.getPlayerListFromDB();
	
	public static void deletePlayer(int id) {
		for (int i = 0; i < list.size(); i++) {
			if (list.get(i).getId() == id) {
				list.remove(i);
				deletePlayerDB(id);
				break;
		}
	}
}
	private static boolean checkPlayer(int id) {
		for (player p: list) {
			if (p.getId() == id) {
				return false; 
			}
		}
		return true;
	}
	
	public static player getPlayerById (int id) {
		for (player p: list) {
			if (p.getId() == id) {
				return p;
			}
		}
		return null;
	}
		
	public static void deletePlayerDB(int id){
		Statement stmt = null;
		Connection c = Process.connectDB();
		try {
		stmt = c.createStatement();
		stmt.addBatch( "DELETE FROM player WHERE id= " + id);
		stmt.addBatch( "DELETE FROM playfor WHERE id= " + id);
		stmt.executeBatch();
        stmt.close();
         c.close();
} catch (Exception e) {
	e.printStackTrace();
}
		}
	
	public static boolean addPlayer(int id, String name, String nation, String position, int ovr, String teamid, int squadnum) {
		if (checkPlayer(id)) {
    	player player = new player();
		player.setId(id);
    	player.setName(name);
    	player.setOvr(ovr);
    	player.setNation(nation);
    	player.setPosition(position);
    	player.setTeamid(teamid);
    	player.setSquadnum(squadnum);
    	list.add(player);
    	addPlayertoDB(id,name,nation,position,ovr,teamid,squadnum);
    	return true;
		}
		else
			return false;
}
	
	public static void addPlayertoDB(int id, String name, String nation, String position, int ovr, String teamid, int squadnum) {
		Connection c = Process.connectDB();
		PreparedStatement stmt = null;
		try {
		stmt = c.prepareStatement("INSERT INTO player(id, name, position, nation, ovr) VALUES (?, ?, ?, ?, ?)");
		stmt.setInt(1,id);
		stmt.setString(2,name);  
		stmt.setString(3,position);
		stmt.setString(4,nation);
		stmt.setInt(5,ovr);
		stmt.executeUpdate(); 
        stmt.close();
		stmt = c.prepareStatement("INSERT INTO playfor(id, name, teamid, squadnum) VALUES (?, ?, ?, ?)");
		stmt.setInt(1,id);
		stmt.setString(2,name);  
		stmt.setString(3,teamid);
		stmt.setInt(4,squadnum);
		stmt.executeUpdate(); 
        stmt.close();
         c.close();
} catch (Exception e) {
	e.printStackTrace();
}
	}
	
}
