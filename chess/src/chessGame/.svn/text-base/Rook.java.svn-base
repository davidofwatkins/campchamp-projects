/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class Rook extends ChessPiece {

	private static final long serialVersionUID = -6149299980048882325L;
	private String imgURL = "images/" + getTeam() + "/rook.gif";
	
	public Rook(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "rook";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();		
		
		//Loop that continues UNTIL there's an object in its way
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord + i, xCoord));
			if (!Game.map.isFree(yCoord + i, xCoord)) { break; }
		}
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord - i, xCoord));
			if (!Game.map.isFree(yCoord - i, xCoord)) { break; }
		}
		
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord, xCoord + i));
			if (!Game.map.isFree(yCoord, xCoord + i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord, xCoord - i));
			if (!Game.map.isFree(yCoord, xCoord - i)) { break; }
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
