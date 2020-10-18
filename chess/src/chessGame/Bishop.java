/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class Bishop extends ChessPiece {

	private static final long serialVersionUID = 8912424521293880762L;
	private String imgURL = "images/" + getTeam() + "/bishop.gif";
	
	public Bishop(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "bishop";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();		
		
		//Loop that continues UNTIL there's an object in its way
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord + i, xCoord + i));
			if (!Game.map.isFree(yCoord + i, xCoord + i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord + i, xCoord - i));
			if (!Game.map.isFree(yCoord + i, xCoord - i)) { break; }
		}
		
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord - i, xCoord + i));
			if (!Game.map.isFree(yCoord - i, xCoord + i)) { break; }
		}
		for (int i = 1; i <= 8; i++) {
			set.add(new CoordSet(yCoord - i, xCoord - i));
			if (!Game.map.isFree(yCoord - i, xCoord - i)) { break; }
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
