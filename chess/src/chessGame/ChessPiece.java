/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.io.Serializable;
import java.util.ArrayList;

public class ChessPiece implements Serializable {
	
	private static final long serialVersionUID = 4276903932362163444L;
	protected int yCoord;
	protected int xCoord;
	protected String team; //Either "white" or "black", set to N/A for empty
	private String imgURL = "images/knight.gif"; //"Default" chess pieces will not show an image
	
	public ChessPiece(String newTeam, int y, int x) {
		team = newTeam;
		yCoord = y;
		xCoord = x;
	}
	
	public void setCoords(int y, int x) {
		yCoord = y;
		xCoord = x;
	}
	
	public int getRow() {
		return yCoord;
	}
	public int getColumn() {
		return xCoord;
	}
	public void setTeam(String newTeam) {
		team = newTeam;
	}
	public String getTeam() {
		return team;
	}
	public String getType() {
		return "N/A";
	}
	public ArrayList<CoordSet> calculatePossibleMoves() {
		CoordSet falseSet = new CoordSet(-1, -1);
		ArrayList<CoordSet> set = new ArrayList<CoordSet>();
		set.add(falseSet);
		return set;
	}
	public void setImgURL(String newURL) {
		imgURL = newURL;
	}
	public String getImgURL() {
		return imgURL;
	}
}
