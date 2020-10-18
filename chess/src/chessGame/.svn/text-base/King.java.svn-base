/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class King extends ChessPiece {
	
	private static final long serialVersionUID = 5489771377216331125L;
	private String imgURL = "images/" + getTeam() + "/king.gif";
	
	public King(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "king";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();		
		
		set.add(new CoordSet(yCoord - 1, xCoord));
		set.add(new CoordSet(yCoord + 1, xCoord));
		
		set.add(new CoordSet(yCoord, xCoord - 1));
		set.add(new CoordSet(yCoord, xCoord + 1));
		
		set.add(new CoordSet(yCoord - 1, xCoord - 1));
		set.add(new CoordSet(yCoord - 1, xCoord + 1));
		
		set.add(new CoordSet(yCoord + 1, xCoord - 1));
		set.add(new CoordSet(yCoord + 1, xCoord + 1));
		
		return set;
	}
	
	public void setImgURL(String newURL) {
		imgURL = newURL;
	}
	public String getImgURL() {
		return imgURL;
	}
}
