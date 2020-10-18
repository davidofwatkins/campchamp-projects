package chessGame;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

public class User {
	
	//Gets raw data from user as String
	private String getUserInput() {
		
		String inputline = null;
		BufferedReader reader;
		
		reader = new BufferedReader (new InputStreamReader (System.in));
		
		try {
			inputline = reader.readLine();
		}
		catch(IOException ioe) {
			System.out.println("USER INPUT ERROR");
		}
		return inputline;
	}
	
	//Returns a string from the user input
	public String getString(String query) {
		System.out.print(query + ": ");
		String intext = getUserInput();
		return intext;
	}
	
	//Returns an integer from the user input
	public int getInt(String query) {
		System.out.print(query + ": ");
		int intext = Integer.parseInt(getUserInput());
		
		//If intext is not an integer... else, return
		
		return intext;
	}
	
	//GetDouble()
	public double getDouble(String query) {
		System.out.print(query + ": ");
		double intext = Double.parseDouble(getUserInput());
		
		//If intext is not a double... else, return
		
		return intext;
	}
	
	//GetBoolean()
	public boolean getBoolean(String query) {
		
		int counter = 0;
		while (counter == 0) {
			String intext = getString(query);
			
			if (intext.equalsIgnoreCase("true") || intext.equalsIgnoreCase("t") || intext.equalsIgnoreCase("yes") || intext.equalsIgnoreCase("y")) {
				return true;
			}
			else if (intext.equalsIgnoreCase("false") || intext.equalsIgnoreCase("f") || intext.equalsIgnoreCase("no") || intext.equalsIgnoreCase("n")) {
				return false;
			}
			
			else {
				System.out.println("INPUT NOT RECOGNIZED.");
			}
		} //End While
		return false; //removes error in eclipse
	}
}