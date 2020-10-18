/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class Queen extends ChessPiece {

	private static final long serialVersionUID = -3060163893056020328L;
	private String imgURL = "images/" + getTeam() + "/queen.gif";
	
	public Queen(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "queen";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();		
		
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord - i, xCoord));
			if (!Game.map.isFree(yCoord - i, xCoord)) { break; }
		}
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord + i, xCoord));
			if (!Game.map.isFree(yCoord + i, xCoord)) { break; }
		}
		
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord, xCoord - i));
			if (!Game.map.isFree(yCoord, xCoord - i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord, xCoord + i));
			if (!Game.map.isFree(yCoord, xCoord + i)) { break; }
		}
		
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord - i, xCoord - i));
			if (!Game.map.isFree(yCoord - i, xCoord - i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord - i, xCoord + i));
			if (!Game.map.isFree(yCoord - i, xCoord + i)) { break; }
		}
		
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord + i, xCoord - i));
			if (!Game.map.isFree(yCoord + i, xCoord - i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {			
			set.add(new CoordSet(yCoord + i, xCoord + i));
			if (!Game.map.isFree(yCoord + i, xCoord + i)) { break; }
		}
		
		return set;
	}
	
	public void setImgURL(String newURL) {
		imgURL = newURL;
	}
	public String getImgURL() {
		return imgURL;
	}
}
