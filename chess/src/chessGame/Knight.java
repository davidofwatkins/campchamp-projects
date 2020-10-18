/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class Knight extends ChessPiece {
	
	private static final long serialVersionUID = -1249080993044896877L;
	private String imgURL = "images/" + getTeam() + "/knight.gif";
	
	public Knight(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "knight";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();		
		
		set.add(new CoordSet(yCoord - 2, xCoord + 1));
		set.add(new CoordSet(yCoord - 2, xCoord - 1));
		set.add(new CoordSet(yCoord - 1, xCoord + 2));
		set.add(new CoordSet(yCoord - 1, xCoord - 2));
		
		set.add(new CoordSet(yCoord + 2, xCoord + 1));
		set.add(new CoordSet(yCoord + 2, xCoord - 1));
		set.add(new CoordSet(yCoord + 1, xCoord + 2));
		set.add(new CoordSet(yCoord + 1, xCoord - 2));
		
		return set;
	}
	
	public void setImgURL(String newURL) {
		imgURL = newURL;
	}
	public String getImgURL() {
		return imgURL;
	}
}
