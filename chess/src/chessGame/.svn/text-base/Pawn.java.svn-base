/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.util.ArrayList;

public class Pawn extends ChessPiece {

	private static final long serialVersionUID = 2020929979037155587L;
	
	private String imgURL = "images/" + getTeam() + "/pawn.gif";
	
	public Pawn(String newTeam, int y, int x) {
		super(newTeam, y, x);
	}
	
	public String getType() {
		return "pawn";
	}
	
	public ArrayList<CoordSet> calculatePossibleMoves() {
		
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();
		
		CoordSet advance = null;
		
		//If this is on the white team, it can only move to the right
		if (team.equals("white")) {
			//As long as there are no pieces directly in front of it, it can move forward
			if (Game.map.isFree(yCoord, xCoord + 1) == true) {
				advance = new CoordSet(yCoord, xCoord + 1);
				set.add(advance);
				//Allow moving two spaces if it's the first turn
				if (xCoord == 1 && Game.map.isFree(yCoord, xCoord + 2) == true) {
					set.add(new CoordSet(yCoord, xCoord + 2));
				}
			}
			//Ask the map if there are enemies that can be killed
			if (Game.map.hasEnemyPiece("white", yCoord + 1, xCoord + 1)) {
				set.add(new CoordSet(yCoord + 1, xCoord + 1));
			}
			if (Game.map.hasEnemyPiece("white", yCoord - 1, xCoord + 1)) {
				set.add(new CoordSet(yCoord - 1, xCoord + 1));
			}
		}
		//If this is on the black team, it can only move to the left
		else if (team.equals("black")) {
			//As long as there are no pieces directly in front of it, it can move forward
			if (Game.map.isFree(yCoord, xCoord - 1) == true) {
				advance = new CoordSet(yCoord, xCoord - 1);
				set.add(advance);
				//Allow moving two spaces if it's the first turn
				if (xCoord == 6 && Game.map.isFree(yCoord, xCoord - 2) == true) {
					set.add(new CoordSet(yCoord, xCoord - 2));
				}
			}
			//Ask the map if there are enemies that can be killed
			if (Game.map.hasEnemyPiece("black", yCoord + 1, xCoord - 1)) {
				set.add(new CoordSet(yCoord + 1, xCoord - 1));
			}
			if (Game.map.hasEnemyPiece("black", yCoord - 1, xCoord - 1)) {
				set.add(new CoordSet(yCoord - 1, xCoord - 1));
			}
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
