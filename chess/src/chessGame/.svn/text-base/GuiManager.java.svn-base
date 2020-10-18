/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */
package chessGame;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import javax.swing.BorderFactory;
import javax.swing.Box;
import javax.swing.BoxLayout;
import javax.swing.ImageIcon;
import javax.swing.JDialog;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JSeparator;
import javax.swing.SwingConstants;
import javax.swing.border.EmptyBorder;

public class GuiManager {
	
	private JPanel chessBoard;
	private JPanel whiteJail;
	private JPanel blackJail;
	private JFrame gameFrame;
	private JMenuBar menuBar;
	private JLabel turnLabel;
	private ChessButton[][] buttons = new ChessButton[8][8];
	private CoordSet originOfSelectedPiece = new CoordSet(-1, -1);
	private Color highlightEmpty = new Color(000, 184, 255);
	private Color highlightEnemy = new Color(178, 034, 034);
	private int numWhiteJailed = 0;
	private int numBlackJailed = 0;
	
	//Listeners
	private CloseListener closeListener = new CloseListener();
	private PieceListener pieceListener = new PieceListener();
	private MovePieceListener movePieceListener = new MovePieceListener();
	private ShowDebugListener showDebugListener = new ShowDebugListener();
	private RestartGameListener restartGameListener = new RestartGameListener();
	private SaveGameListener saveGameListener = new SaveGameListener();
	private LoadGameListener loadGameListener = new LoadGameListener();
	private InstructionsListener instructionsListener = new InstructionsListener();
	private CreditsListener creditsListener = new CreditsListener();
	
	public GuiManager() {
		
		//Set up the window
		gameFrame = new JFrame("Chess");
		gameFrame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		gameFrame.setResizable(true);
		gameFrame.setSize(800, 623);
		
		//Create the Menu Bar
		menuBar = new JMenuBar();
		
		JMenu file = new JMenu("File");
		JMenu help = new JMenu("Help");
		JMenu debug = new JMenu("Debug");
		turnLabel = new JLabel("It is currently the " + Game.map.getTurn().toUpperCase() + " team's turn.", SwingConstants.RIGHT);
		
		JMenuItem saveGameButton = new JMenuItem("Save Game...");
		JMenuItem loadNewGameButton = new JMenuItem("Load Saved Game...");
		JSeparator sep = new JSeparator();
		JMenuItem exitButton = new JMenuItem("Exit");
		JMenuItem instructions = new JMenuItem("About Chess");
		JMenuItem about = new JMenuItem("About");
		JMenuItem showDebug = new JMenuItem("Print debug info to console...");
		JMenuItem restartGame = new JMenuItem("Restart Game");
		
		exitButton.addActionListener(closeListener);
		saveGameButton.addActionListener(saveGameListener);
		loadNewGameButton.addActionListener(loadGameListener);
		showDebug.addActionListener(showDebugListener);
		restartGame.addActionListener(restartGameListener);
		instructions.addActionListener(instructionsListener);
		about.addActionListener(creditsListener);
		
		menuBar.add(file);
		menuBar.add(help);
		menuBar.add(debug);
		menuBar.add(Box.createHorizontalGlue());
		menuBar.add(turnLabel);
		menuBar.setBorder(new EmptyBorder(0, 0, 0, 10));
		file.add(saveGameButton);
		file.add(loadNewGameButton);
		file.add(sep);
		file.add(restartGame);
		file.add(exitButton);
		help.add(instructions);
		help.add(about);
		debug.add(showDebug);
		
		//Create the jail areas
		whiteJail = new JPanel();
		blackJail = new JPanel();
		whiteJail.setLayout(new BoxLayout(whiteJail, BoxLayout.PAGE_AXIS));
		blackJail.setLayout(new BoxLayout(blackJail, BoxLayout.PAGE_AXIS));
		whiteJail.setBorder(new EmptyBorder(10, 10, 10, 10));
		blackJail.setBorder(new EmptyBorder(10, 10, 10, 10));
		whiteJail.setPreferredSize(new Dimension(80, gameFrame.getHeight()));
		blackJail.setPreferredSize(new Dimension(80, gameFrame.getHeight()));
		whiteJail.add(Box.createVerticalStrut(10)); //Spacing between components in box layout
		blackJail.add(Box.createVerticalStrut(10)); //Spacing between components in box layout
		Color jailBg = new Color(238, 255, 255);
		whiteJail.setBackground(jailBg);
		blackJail.setBackground(jailBg);
		
		//Draw the chessboard
		renderBoard();
		
		//Add everything to the Frame and draw it
		gameFrame.getContentPane().add(BorderLayout.NORTH, menuBar);
		gameFrame.getContentPane().add(chessBoard);
		gameFrame.getContentPane().add(BorderLayout.WEST, whiteJail);
		gameFrame.getContentPane().add(BorderLayout.EAST, blackJail);
        gameFrame.setLocationRelativeTo(null);
		gameFrame.setVisible(true);
	}
	
	//Draw the chessboard using the ChessMap to find out what pieces go where
	private void renderBoard() {
		GridLayout glayout = new GridLayout(8, 8, 0, 0);
		chessBoard = new JPanel(glayout);
		chessBoard.setBorder(BorderFactory.createEmptyBorder());
		
		for (int r = 0; r <= 7; r++) {
			for (int c = 0; c <= 7; c++) {
				//Create a new ChessButton
				if (!Game.map.getPiece(r, c).getType().equals("N/A")) {
					buttons[r][c] = new ChessButton(Game.map.getPiece(r, c).getType(), Game.map.getPiece(r, c).getImgURL(), Game.map.getPiece(r, c).getTeam());
				}
				else { buttons[r][c] = new ChessButton("", Game.map.getPiece(r, c).getImgURL(), Game.map.getPiece(r, c).getTeam()); }
				buttons[r][c].setCoords(r, c);
				chessBoard.add(buttons[r][c]);
			}
		}
		
		//Give every button the 'default' listener
		restoreButtonListeners();
		restoreBoardColors();
		
		//Update the jails (for when a previous game is being loaded)
		updateJails();
	}
	
	//Updates the chessboard by making sure each button label matches each type of its corresponding chesspiece in ChessMap
	private void updateBoard() {
		for (int r = 0; r <= 7; r++) {
			for (int c = 0; c <= 7; c++) {
				//DISABLED BECAUSE CAUSES BUG WHERE PIECES DON'T SHOW THE CORRECT COLOR (or an image at all) --> if (!buttons[r][c].getLabel().equals(Game.map.getPiece(r, c).getType())) {
					// DISABLED WHEN GAME IS NO LONGER TEXT-BASED: if (!Game.map.getPiece(r, c).getType().equals("N/A")) { buttons[r][c].setText(Game.map.getPiece(r, c).getType()); } //Update the button's text/type/label
					//else { buttons[r][c].setText(""); }
					buttons[r][c].setTeam(Game.map.getPiece(r, c).getTeam()); //Update the button's team
					buttons[r][c].setCoords(r, c); //Update it's coords
					buttons[r][c].setImgURL(Game.map.getPiece(r, c).getImgURL());
				//}
			}
		}
		//Update the current team's turn
		menuBar.remove(turnLabel);
		turnLabel = new JLabel("It is currently the " + Game.map.getTurn().toUpperCase() + " team's turn.");
		menuBar.add(turnLabel);
		
		//Update the jails
		updateJails();
	}
	
	private void updateJails() {
		//Fill the jails
		ArrayList<ChessPiece> whiteJailMembers = Game.map.getJailedPieces("white");
		ArrayList<ChessPiece> blackJailMembers = Game.map.getJailedPieces("black");
		
		//If there is a new piece in the jail (in ChessMap), add it to the Panel for the user to see
		if (whiteJailMembers.size() > numWhiteJailed) {
			int tempSize = whiteJailMembers.size();
			whiteJail.add(new JLabel(new ImageIcon(whiteJailMembers.get(tempSize - 1).getImgURL())));
			whiteJail.add(Box.createVerticalStrut(10)); //Spacing between components in box layout
			System.out.println("Checked white jails!");
			numWhiteJailed++;
		}
		//If there is a new piece in the jail (in ChessMap), add it to the Panel for the user to see
		if (blackJailMembers.size() > numBlackJailed) {
			int tempSize = blackJailMembers.size();
			blackJail.add(new JLabel(new ImageIcon(blackJailMembers.get(tempSize - 1).getImgURL())));
			blackJail.add(Box.createVerticalStrut(10)); //Spacing between components in box layout
			System.out.println("Checked black jails!");
			numBlackJailed++;
		}
		System.out.println("blackJailMembers.size() = " + blackJailMembers.size() + ", and numBlackJaled = " + numBlackJailed);
	}
	
	//Highlights the places on the board where the user can move a piece to
	public void highlightPossibleMoves(ArrayList<CoordSet> possibleMoves, CoordSet origin) {
		originOfSelectedPiece = origin;
		
		//Change the button listener of the origin piece
		buttons[origin.getRow()][origin.getColumn()].removeActionListener(pieceListener);
		buttons[origin.getRow()][origin.getColumn()].addActionListener(movePieceListener);
		
		//Disable every button
		for (int r = 0; r <= 7; r++) {
			for (int c = 0; c <= 7; c++) {
				buttons[r][c].setEnabled(false);
			}
		}
		
		//Highlight the buttons of possible moves and change their button listeners
		for (int i = 0; i <= possibleMoves.size() - 1; i++) {
			int tempY = possibleMoves.get(i).getRow();
			int tempX = possibleMoves.get(i).getColumn();
			
			if (!Game.map.getPiece(tempY, tempX).getType().equals("N/A")) {
				buttons[tempY][tempX].setBackground(highlightEnemy);
			}
			else {
				buttons[tempY][tempX].setBackground(highlightEmpty);
			}
			buttons[tempY][tempX].removeActionListener(pieceListener);
			buttons[tempY][tempX].addActionListener(movePieceListener);
			buttons[tempY][tempX].setEnabled(true); //Only enable the buttons that the user can move to
			buttons[origin.getRow()][origin.getColumn()].setEnabled(true); //Allow the user to click the original button if he/she wants to cancel
		}
	}
	
	//Used to restore all the colors of the board to black and white after some have been changed to show the user possible moves
	private void restoreBoardColors() {
		int colorCounter = 0;
		for (int r = 0; r <= 7; r++) {
			for (int c = 0; c <= 7; c++) {
				if (colorCounter == 1 || colorCounter == 3 || colorCounter == 5 || colorCounter == 7) { buttons[r][c].setBackground(Color.GRAY); }
				else { buttons[r][c].setBackground(Color.WHITE); }
				buttons[r][c].setEnabled(true); //Make sure they're all enabled
				colorCounter++;
			}
			//Reset the colorCounter to 1 or 0, depending on whether the row starts with black or white
			if (colorCounter == 8) { colorCounter = 1; }
			else { colorCounter = 0; }
		}
	}
	
	//Used to restore the PieceListener to all buttons on the grid after changing some to allow the user to move a piece to them
	private void restoreButtonListeners() {
		for (int r = 0; r <= 7; r++) {
			//Remove ALL listeners for each button (safer to remove all than just try to remove one of two)
			for (int c = 0; c <= 7; c++) {
				for (int i = 0; i < buttons[r][c].getActionListeners().length; i++) {
					buttons[r][c].removeActionListener(buttons[r][c].getActionListeners()[0]);
				}
			}
			
			//Add a piece listener
			for (int c = 0; c <= 7; c++) {
				buttons[r][c].removeActionListener(movePieceListener);
				buttons[r][c].addActionListener(pieceListener);
				
			}
		}
	}
	
	public void makePopup(String dialog) {
		JOptionPane.showMessageDialog(gameFrame, dialog);
	}
	
	private void showDebugInfo() {
		System.out.println("******PIECE LOCATIONS******");
		Game.map.showBoard();
		System.out.println("******GUI VARIABLES & INFORMATION******");
		System.out.println("Origin of Selected Pieces: Row: " + originOfSelectedPiece.getRow() + ", Col: " + originOfSelectedPiece.getColumn());
		System.out.println();
		System.out.println("Buttons with the CloseListener action listener:");
		for (int r = 0; r <= 7; r++) {
			for (int c = 0; c <= 7; c++) {
				if (buttons[r][c].getActionListeners()[0] == pieceListener) {
					System.out.println("Piece Listener - Row: " + r + ", Col: " + c);
					if (buttons[r][c].getActionListeners().length > 1) { System.out.println("But there's another!  There are " + buttons[r][c].getActionListeners().length); }
				}
				else if (buttons[r][c].getActionListeners()[0] == movePieceListener) {
					System.out.println("Move Piece Listener - Row: " + r + ", Col: " + c);
					if (buttons[r][c].getActionListeners().length > 1) { System.out.println("But there's another!  There are " + buttons[r][c].getActionListeners().length); }
				}
			}
		}
	}
	
	public boolean askYesOrNo(String name, String question) {
		JOptionPane pane = new JOptionPane(question);
		Object[] options = new String[2];
		options[0] = "Yes";
		options[1] = "No";
		pane.setOptions(options);
		JDialog dialog = pane.createDialog(new JFrame(), name);
		dialog.setVisible(true);
		if (pane.getValue().equals("Yes")) { return true; }
		else { return false; }
	}
	
	public String getFile() {
		JFileChooser fileOpen = new JFileChooser();
		int ret = fileOpen.showDialog(null, "Open");
		
		if (ret == JFileChooser.APPROVE_OPTION) {
			File file = fileOpen.getSelectedFile();
			return file.toString();
		}
		else if (ret == JFileChooser.CANCEL_OPTION) {
			return "cancel";
		}
		else { return "ERROR"; }
	}
	
	public String saveFile() {
		JFileChooser fileSave = new JFileChooser();
		int ret = fileSave.showDialog(null, "Save...");
		
		if (ret == JFileChooser.APPROVE_OPTION) {
			File file = fileSave.getSelectedFile();
			return file.toString();
		}
		else { return "ERROR"; }
	}
	
	public void closeFrame() {
		gameFrame.dispose();
	}
	
	//Listeners
	class CloseListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			if (askYesOrNo("Are you sure?", "Are you sure you want to end the game?") == true) {
				System.exit(0);
			}
		}
	}
	class RestartGameListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			if (askYesOrNo("Are you sure?", "Are you sure you want to restart the game?") == true) {
				gameFrame.dispose();
				Game.restartGame();
			}
		}
	}
	
	class SaveGameListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			Game.saveGame();
		}
	}
	class LoadGameListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			Game.loadGame();
		}
	}
	
	class ShowDebugListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			showDebugInfo();
		}
	}
	
	class CreditsListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			makePopup("This chess game was created by David Watkins in Fall 2010 as a\n" +
					"project for Champlain College's SWE-150-01 Java Programming class.\n" +
					"Beware, there are several known issues and bugs with this software\n" +
					"that may not have been resolved yet.  For more information, feel\n" +
					"free to contact david@davidofwatkins.com or visit\n" +
					"www.davidofwatkins.comfor more information.  Thank you!");
		}
	}
	
	class InstructionsListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			try { Runtime.getRuntime().exec("hh.exe http://en.wikipedia.org/wiki/Chess#Rules"); }
			catch (IOException e) {
				System.err.println("Error: could not open web browser.");
				makePopup("Error: could not open web browser.");
			}
			/*Desktop desktop = null;
			if (Desktop.isDesktopSupported()) { desktop = Desktop.getDesktop(); }
			else { System.err.println("Desktop not supported");
			try { desktop.browse(new URI("http://www.google.com")); }
			catch (IOException e) { System.err.println("Error opening browser: IOException"); }
			catch (URISyntaxException e) { System.err.println("Error with URI syntax"); }*/
		}
	}
	
	class PieceListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			int yCoord = ((ChessButton) event.getSource()).getYCoord();
			int xCoord = ((ChessButton) event.getSource()).getXCoord();
			System.out.println("Selected Piece: Row " + yCoord + ", Col " + xCoord);
			
			//Start moving the piece
			Game.map.initiateMove(yCoord, xCoord);
			updateBoard();
		}
	}
	
	class MovePieceListener implements ActionListener {
		public void actionPerformed(ActionEvent event) {
			int yCoord = ((ChessButton) event.getSource()).getYCoord();
			int xCoord = ((ChessButton) event.getSource()).getXCoord();
			
			CoordSet destination = new CoordSet(yCoord, xCoord);
			
			Game.map.movePiece(originOfSelectedPiece, destination);
			originOfSelectedPiece.setCoords(-1, -1);
			updateBoard();
			restoreButtonListeners();
			restoreBoardColors();
		}
		
	}
}
