/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.io.Serializable;

import javax.swing.ImageIcon;
import javax.swing.JButton;

public class ChessButton extends JButton implements Serializable {

	private static final long serialVersionUID = 1570540233282525098L;
	public int yCoord;
	public int xCoord;
	private String team;
	private String label;
	
	public ChessButton(String newLabel, String iconURL, String team) {
		super(new ImageIcon(iconURL));
		label = newLabel;
		this.setBorderPainted(false);
	}
	
	public void setCoords(int y, int x) {
		yCoord = y;
		xCoord = x;
	}
	
	public int getYCoord() {
		return yCoord;
	}
	
	public int getXCoord() {
		return xCoord;
	}
	public String getTeam() {
		return team;
	}
	public void setTeam(String newTeam) {
		team = newTeam;
	}
	public String getLabel() {
		return label;
	}
	public void setText(String newLabel) {
		label = newLabel;
		super.setText(newLabel);
	}
	public void setImgURL(String iconURL) {
		super.setIcon(new ImageIcon(iconURL));
	}
}
