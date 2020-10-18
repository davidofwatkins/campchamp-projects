/**
 * David's Chess Game
 * Originally created as a project for Champlain College's SWE-150-01 Java Programming course.
 */

package chessGame;

import java.io.Serializable;
import java.util.ArrayList;

public class ChessMap implements Serializable {

	private static final long serialVersionUID = 7787159416225360673L;
	
	//Initialize 2-dimentional grid Array
	private ChessPiece[][] grid;
	private ArrayList<ChessPiece> whiteJail = new ArrayList<ChessPiece>(); //Holds enemy black pieces
	private ArrayList<ChessPiece> blackJail = new ArrayList<ChessPiece>(); //Holds enemy white pieces
	private String turn = "white";
	
	public ChessMap() {
		
		grid = new ChessPiece[8][8];
		
		/******Place empty ChessPieces in all the squares by default******/
		for (int r = 0; r < grid.length; r++) {
			for (int c = 0; c < grid[r].length; c++) {
				grid[r][c] = new ChessPiece("N/A", -1, -1);
			}
		}
		
		/******Add the correct pieces in the correct spaces******/
		
		//First Column (white)
		grid[0][0] = new Rook("white", 0, 0);
		grid[1][0] = new Knight("white", 1, 0);
		grid[2][0] = new Bishop("white", 2, 0);
		grid[3][0] = new King("white", 3, 0);
		grid[4][0] = new Queen("white", 4, 0); //Queen should always be placed on its color
		grid[5][0] = new Bishop("white", 5, 0);
		grid[6][0] = new Knight("white", 6, 0);
		grid[7][0] = new Rook("white", 7, 0);
		
		//Second Column - Pawns (white)
		for (int i = 0; i <= 7; i++) {
			grid[i][1] = new Pawn("white", i, 1);
		}
		
		//Third Column - Pawns (black)
		for (int i = 0; i <= 7; i++) {
			grid[i][6] = new Pawn("black", i, 6);
		}
		
		//Fourth Column (black)
		grid[0][7] = new Rook("black", 0, 7);
		grid[1][7] = new Knight("black", 1, 7);
		grid[2][7] = new Bishop("black", 2, 7);
		grid[3][7] = new King("black", 3, 7);
		grid[4][7] = new Queen("black", 4, 7); //Queen should always be placed on its color
		grid[5][7] = new Bishop("black", 5, 7);
		grid[6][7] = new Knight("black", 6, 7);
		grid[7][7] = new Rook("black", 7, 7);
	}
	
	//Used by the GuiManager to ask which piece is in a specific location
	public ChessPiece getPiece(int y, int x) {
		return grid[y][x];
	}
	
	//Used by ChessPieces to ask if a specific point has an enemy piece on it
	public boolean hasEnemyPiece(String friendlyTeam, int yCoord, int xCoord) {
		
		//Make sure the gridlocation exists on the map
		if (yCoord > 7 || xCoord > 7 || yCoord < 0 || xCoord < 0) {
			return false;
		}
		
		String enemyTeam = null;
		
		if (friendlyTeam.equals("white")) { enemyTeam = "black"; }
		else if (friendlyTeam.equals("black")) { enemyTeam = "white"; }
		
		if (grid[yCoord][xCoord].getTeam().equals(enemyTeam)) {
			return true;
		}
		else { return false; }
	}
	
	//Used by Pawn to see if there is a free space in front of it
	public boolean isFree(int yCoord, int xCoord) {
		
		//Make sure the gridlocation exists on the map
		if (yCoord > 7 || xCoord > 7 || yCoord < 0 || xCoord < 0) {
			return false;
		}
		
		if (grid[yCoord][xCoord].getType().equals("N/A")) {
			return true;
		}
		else { return false; }
	}
	
	//Used by Game or GuiManager when the user indicates that he wants to move a specific piece
	public void initiateMove(int originY, int originX) {
		//Get the list of possible moves that this piece can make
		ArrayList<CoordSet> possibleMoves = grid[originY][originX].calculatePossibleMoves();
		
		//If the user tries to move a piece that doesn't exist (?)
		if (possibleMoves.size() != 0 && possibleMoves.get(0).getRow() == -1 && possibleMoves.get(0).getColumn() == -1) {
			System.err.println("ERROR: NO VALID PIECE EXISTS AT ROW " + originY + ", COLUMN " + originX + "!");
			//Make a popup telling the user that there's nothing to select:
			Game.gui.makePopup("There is no piece there to select.");
		}
		else if (!grid[originY][originX].getTeam().equals(turn)) {
			Game.gui.makePopup("Sorry, it is not your turn!");
		}
		else {
			//Remove any coordinates that are off the grid
			possibleMoves = removeNullCoords(possibleMoves);
			
			//Check to make sure there are no friendlies in any of the possibleMoves
			for (int i = 0; i <= possibleMoves.size() - 1; i++) {
				if (grid[possibleMoves.get(i).getRow()][possibleMoves.get(i).getColumn()].getTeam().equals(grid[originY][originX].getTeam())) {
					possibleMoves.remove(i);
					i = i - 1; //CRITICAL!
				}
			}
			
			//Print out possible locations (this will be eventually be done through the GUI)
			if (possibleMoves.size() == 0) {
				System.out.println("There are no locations you can move this piece to.");
				Game.gui.makePopup("There are no locations you can move this piece to.");
			}
			
			//Make sure the piece the user wants to move is actually a piece (and not just a N/A piece)
			else {
				CoordSet origin = new CoordSet(originY, originX);
				Game.gui.highlightPossibleMoves(possibleMoves, origin);
			}
		}
	}
	
	public void movePiece(CoordSet origin, CoordSet destination) {
		
		int originY = origin.getRow();
		int originX = origin.getColumn();
		
		int newY = destination.getRow();
		int newX = destination.getColumn();
		
		if (originY == newY && originX == newX) {
			System.out.println("Move cancelled!");
		}
		else {
			boolean isCheckMate = false;
			
			//End the game if a king is killed
			if (grid[newY][newX].getType().equals("king")) {
				Game.setGameOver(grid[originY][originX].getTeam());
			}
			
			//Check to see if anything's been killed/captured, and act accordingly
			if (!grid[newY][newX].getTeam().equals("N/A")) {
				if (grid[originY][originX].getTeam().equals("white")) { whiteJail.add(grid[newY][newX]); /*Game.gui.numWhiteJailed++;*/ }
				else if (grid[originY][originX].getTeam().equals("black")) { blackJail.add(grid[newY][newX]); /*Game.gui.numBlackJailed++;*/ } 
				else { System.err.println("ERROR: Could not detect piece team when adding to jail"); }
			}
			
			//Move the piece
			grid[newY][newX] = grid[originY][originX]; //1) Copy piece to new location
			grid[newY][newX].setCoords(newY, newX); //2) Inform the piece of its new coords,
			grid[originY][originX] = new ChessPiece("N/A", -1, -1); //3) replace the old coordinates with a blank ChessPiece
			
			System.out.println("Piece moved from row " + originY + ", col " + originX + " to row " + newY + ", col " + newX + ".");
			
			
			//Check for "checkmate"
			//Search for the kings and determine if they are in checkmate:
			for (int r = 0; r < grid.length; r++) {
				for (int c = 0; c < grid[r].length; c++) {
					if (grid[r][c].getType().equals("king")) {
						if (isInCheckMate(new CoordSet(r, c)) == true && !grid[r][c].getTeam().equals(turn)) { //Make sure that it's not the king's turn...right?
							Game.gui.makePopup("Check Mate!");
							isCheckMate = true;
						}
					}
				}
			}
			
			if (isCheckMate == false) { //Prevents the game from shouting "check" and "checkmate" at the same time
				//Change teams
				if (turn.equals("white")) { turn = "black"; }
				else if (turn.equals("black")) { turn = "white"; }
				
				//Check for "check"
				if (isInCheck(destination, grid[newY][newX].getType()) == true) {
					Game.gui.makePopup("Check!");
				}
			}
		}
	}
	
	/***MERGE isThreatened() AND checkForCheck() INTO ONE METHOD!***/
	private boolean isInCheck(CoordSet piece, String pieceType) {
		String enemyTeam = "";
		if (grid[piece.getRow()][piece.getColumn()].getTeam().equals("white")) { enemyTeam = "black"; }
		else { enemyTeam = "white"; }
		
		//If the piece is a king:
		if (pieceType.equals("king")) { //Have to have the type entered into the method manually to allow isInCheckMate() to 
			//Check every ENEMY piece on the board to see if it is in range of the current piece
			for (int r = 0; r < grid.length; r++) {
				for (int c = 0; c < grid[r].length; c++) {
					//If grid[r][c] is an enemy piece
					if (grid[r][c].getTeam().equals(enemyTeam)) {
						ArrayList<CoordSet> possibleMoves = grid[r][c].calculatePossibleMoves();
						possibleMoves = removeNullCoords(possibleMoves);
						//Check each possibleMove of the currently selected piece to see if the kind is one of them
						for (int i = 0; i < possibleMoves.size(); i++) {
							if (possibleMoves.get(i).getRow() == piece.getRow() && possibleMoves.get(i).getColumn() == piece.getColumn()) {
								return true;
							}
						}
					}
				}
			}
		}
		
		//If the piece is NOT a king:
		else {
			ArrayList<CoordSet> possibleMoves = grid[piece.getRow()][piece.getColumn()].calculatePossibleMoves();
			possibleMoves = removeNullCoords(possibleMoves);
			
			//Check each of the positions the piece could be moved to to see...
			for (int i = 0; i < possibleMoves.size(); i++) {
				//...if any of them are occupied by an enemy king
				if (grid[possibleMoves.get(i).getRow()][possibleMoves.get(i).getColumn()].getType().equals("king") && grid[possibleMoves.get(i).getRow()][possibleMoves.get(i).getColumn()].getTeam().equals(enemyTeam)) {
					return true;
				}
			}
		}
		
		return false;
	}
	//(Any time anything moves) check to see if the king is in check-mate (i.e., if he will still be in check no matter what position he moves to)
	private boolean isInCheckMate(CoordSet piece) {
		
		//Establish the king's possible moves
		ArrayList<CoordSet> kingsPossibleMoves = grid[piece.getRow()][piece.getColumn()].calculatePossibleMoves();
		kingsPossibleMoves = removeNullCoords(kingsPossibleMoves);
		
		int counter = 0;
		if (isInCheck(piece, "king") == true) {
			for (int i = 0; i < kingsPossibleMoves.size(); i++) {
				if (isInCheck(new CoordSet(kingsPossibleMoves.get(i).getRow(), kingsPossibleMoves.get(i).getColumn()), "king") == true) { counter++; } //Putting "king" in forces it to treat each check as if it's checking a king
			}
		}
		//System.out.println("Counter is " + counter + ", and kingsPossibleMoves.size() is " + kingsPossibleMoves.size());
		if (counter == kingsPossibleMoves.size()) { return true; }
		else { return false; }
	}
	
	//Used by initializeMove(), movePiece(), and checkForCheck() to remove CoordSets that are off the grid and might throw errors
	private ArrayList<CoordSet> removeNullCoords(ArrayList<CoordSet> set) {
		for (int i = 0; i <= set.size() - 1; i++) {  
			if (set.get(i).getRow() > 7 || set.get(i).getColumn() > 7 || set.get(i).getRow() < 0 || set.get(i).getColumn() < 0) {
				set.remove(i);
				i = i - 1; //CRITICAL! - Because you're removing a possibleMove (above), the arrayList is going to shrink
			}
		}
		return set;
	}
	
	//Used by the gui to show who's turn it currently is
	public String getTurn() {
		return turn;
	}
	
	//Used by the Gui to show the killed/captured pieces for each team
	public ArrayList<ChessPiece> getJailedPieces(String jail) {
		if (jail.equals("white")) { return whiteJail; }
		else if (jail.equals("black")) { return blackJail; }
		else { return null; }
	}
	
	public void showBoard() {
		//Print the contents of each square
		for (int r = 0; r < grid.length; r++) {
			for (int c = 0; c < grid[r].length; c++) {
				//System.out.println(" " + grid[r][c]);
				System.out.println("Row: " + r + ", Column: " + c + ": " + grid[r][c].getTeam() + " " + grid[r][c].getType());
			}
			System.out.println();
		}
		
		//Print the contents of the jails (if there is anything in them)
		if (whiteJail.size() != 0) {
			System.out.println("Contents of the white jail:");
			for (int i = 0; i <= whiteJail.size() - 1; i++) {
				System.out.println(whiteJail.get(i).getTeam() + " " + whiteJail.get(i).getType());
			}
		}
		if (blackJail.size() != 0) {
			System.out.println("Contents of the black jail:");
			for (int i = 0; i <= blackJail.size() - 1; i++) {
				System.out.println(blackJail.get(i).getTeam() + " " + blackJail.get(i).getType());
			}
		}
	}
}
