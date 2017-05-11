import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

/**
 * Created by Robin on 11/05/2017.
 */
public class UserManager extends HttpServlet {

// http://usermanager-167313.appspot.com/hello?name=Robin&achtername=Bamps
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/plain");
        String name = request.getParameter("name");
        String achtername = request.getParameter("achtername");
        if (name.equals("Robin")){
            response.getWriter().println("2795262");
        }
        else if(name.equals("Kobe")){
            response.getWriter().print("2795649");
        }
        else if(name.equals("Joris")){
            response.getWriter().print("2790357");
        }
        else
        {
            response.getWriter().print("User not known");
        }

    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String name = request.getParameter("name");
        response.setContentType("text/plain");
        if (name == null) {
            response.getWriter().println("Please enter a name");
        }
        response.getWriter().println("Hello " + name);
    }
}
