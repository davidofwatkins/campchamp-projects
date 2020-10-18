/**
 * David's Chess Game
 * version: 1.0
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 * This source code is available for use with recognition of the author
 */

package chessGame;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;

public class Game {
	
	public static ChessMap map;
	public static GuiManager gui;
	
	public static void main(String[] args) {
		
		map = new ChessMap();  //Must be declared before gui!
		gui = new GuiManager();
	}
	
	//When the game is won, ask if the user wants to play another round
	public static void setGameOver(String winningTeam) {
		//gui.makePopup("Game Over!  The " + winningTeam + " team wins!");
		if (gui.askYesOrNo("Game Over!", "Game Over!  The " + winningTeam + " team wins!  Do you want to play again?") == true) {
			gui.closeFrame();
			map = new ChessMap();
			gui = new GuiManager();
		}
		else {
			System.exit(0);
		}
	}
	public static void restartGame() {
		map = new ChessMap();
		gui = new GuiManager();
	}
	
	//Called when the user wants to save a game to a file
	public static void saveGame() {
		System.out.println("Saving state...");
		String fileName = gui.saveFile();
		try {
			FileOutputStream fs = new FileOutputStream(fileName);
			ObjectOutputStream os = new ObjectOutputStream(fs);
			os.writeObject(map);
			os.close();
			
			System.out.println("State saved");
		}
		catch (IOException e) { e.printStackTrace(); }
	}
	
	//Called when user wants to load a previously saved game
	public static void loadGame() {
		System.out.println("Restoring State");
		String fileName = gui.getFile();
		try {
			FileInputStream fi = new FileInputStream(fileName);
			ObjectInputStream is = new ObjectInputStream(fi);
			Object newMap = is.readObject();
			
			gui.closeFrame(); //Close the old window before making a new one
			
			map = (ChessMap) newMap;
			gui = new GuiManager();
			is.close();
		}
		catch (IOException e) {
			if (!fileName.equals("cancel")) { gui.makePopup("Error reading from file."); } //If statement prevents popop from being made when the user cancels the dialog box
		}
		catch (ClassNotFoundException e) { e.printStackTrace(); }
	}
}

/** TODO/BUGS: 
 *  -investigate problem with jails loading improperly when loading game
 *  -add scrollbars to jails?
 *  -check to see if the file already exists when saving
 *  -investigate issues when check is not caught
 */
