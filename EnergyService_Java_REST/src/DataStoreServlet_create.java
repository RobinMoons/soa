import com.google.appengine.api.datastore.*;
import com.google.appengine.labs.repackaged.org.json.JSONException;
import com.google.appengine.labs.repackaged.org.json.JSONObject;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.BufferedReader;
import java.io.IOException;


/**
 * Created by Robin on 15/05/2017.
 */
public class DataStoreServlet_create extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doGet(request,response);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String pKey = request.getParameter("key");
        String pPostal = request.getParameter("postal");
        String pName = request.getParameter("name");
        String pFirstName = request.getParameter("firstName");
        String pRights = request.getParameter("acces");
        String pDay = request.getParameter("day");
        String pNight = request.getParameter("night");
        String pNormal = request.getParameter("normal");
        String pGreen = request.getParameter("green");

        JSONObject json = new JSONObject();
        response.setContentType("application/json");
        response.setCharacterEncoding("utf-8");

        DatastoreService datastore = DatastoreServiceFactory.getDatastoreService();

        //voorbeeld: http://usermanager-167313.appspot.com/create?key=adminusers&name=Wils&firstName=Joris&postal=3910&acces=get
        //voorbeeld: http://usermanager-167313.appspot.com/create?key=5657382461898752&name=Lampiris&normal=0.0486&day=0.0579&night=0.0389&green=0.0112
        //only with "adminusers" credentials is it possible to create a user
        try
        {
            if (pKey.equals("adminusers")){
                Key sleutel = KeyFactory.createKey("users","create");
                Entity user = new Entity("users", sleutel);
                user.setProperty("name",pName);
                user.setProperty("firstName",pFirstName);
                user.setProperty("Postal",pPostal);
                user.setProperty("Rights",pRights);
                datastore.put(user);
                Key key = user.getKey();
                Long id = key.getId();
                try {
                    json.put("message","succes");
                    JSONObject _user = new JSONObject();
                    _user.put("Name",pName);
                    _user.put("Acces-type",pRights);
                    _user.put("Key", id);
                    json.put("User info", _user);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                //response.getWriter().print("Key for user " + pName + " " + pFirstName + ": " + id);
            }
            else {
                Long keyId = Long.parseLong(pKey);
                Key parentKey = KeyFactory.createKey("users","create");
                Key key = KeyFactory.createKey(parentKey,"users",keyId);
                Query.FilterPredicate keyFilter = new Query.FilterPredicate(Entity.KEY_RESERVED_PROPERTY, Query.FilterOperator.EQUAL, key);
                Query q = new Query("users").setFilter(keyFilter);
                PreparedQuery pq = datastore.prepare(q);
                Entity gebruiker = pq.asSingleEntity();
                if (gebruiker != null) {
                    String acces = gebruiker.getProperty("Rights").toString();
                    JSONObject user = new JSONObject();
                    try {
                        user.put("Name",gebruiker.getProperty("name"));
                        user.put("First name", gebruiker.getProperty("firstName"));
                        user.put("Acces rights", acces);
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    if (acces.equals("set")|| acces.equals("both")) {
                        //check of er niet al een distributor met dezelfde naam in de tabel staat
                        Query.FilterPredicate nameFilter = new Query.FilterPredicate("dist. name", Query.FilterOperator.EQUAL, pName);
                        Query qu = new Query("providers").setFilter(nameFilter);
                        PreparedQuery pqu = datastore.prepare(qu);
                        Entity distributor = pqu.asSingleEntity();
                        //indien niet "all" en niet een al gebruikte naam
                        if(! pName.equals("all") && distributor == null){
                            Key sleutel = KeyFactory.createKey("providers",pName);
                            Entity provider = new Entity("providers", sleutel);
                            double normal, day, night, green;
                            try{
                                normal = Double.parseDouble(pNormal);
                            }
                            catch (Exception ex){ normal = 0.0;}
                            try{
                                day = Double.parseDouble(pDay);
                            }
                            catch (Exception ex){ day = 0.0;}
                            try{
                                night = Double.parseDouble(pNight);
                            }
                            catch (Exception ex){ night = 0.0;}
                            try{
                                green = Double.parseDouble(pGreen);
                            }
                            catch (Exception ex){ green = 0.0;}
                            provider.setProperty("dist. name",pName);
                            provider.setProperty("Normaaltarief",normal);
                            provider.setProperty("Dagtarief",day);
                            provider.setProperty("Nachttarief",night);
                            provider.setProperty("Kost Groen",green);
                            datastore.put(provider);
                            String msg = "distributor: " + pName + " added";
                            try {
                                json.put("message",msg);
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                        else
                        {
                            String msg = pName + " is not a valid distributor name";
                            try {
                                json.put("message",msg);
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }

                    }
                    else {
                        try {
                            json.put("message","Acces denied");
                            json.put("User info", user);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        //response.getWriter().print("No 'get' rights for this user");
                    }
                }
                else {
                    try {
                        json.put("message","Invalid API key");
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    //response.getWriter().print("user not found!");
                }

            }
        }
        catch (Exception ex){
            try {
                json.put("Error",ex.toString());
                json.put("Explanation", "Bad request");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }

        response.getWriter().print(json);
    }

    protected void doOptions(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{
        //Tell the browser what requests we allow.
        response.setHeader("Allow", "GET, POST, OPTIONS");
        response.getWriter().println("method 'create' documentation:");
        response.setContentType("application/json");
        response.setCharacterEncoding("utf-8");

        JSONObject methods = new JSONObject();
        try {
            JSONObject paramKey = new JSONObject();
            paramKey.put("type", "string");
            paramKey.put("description", "API key to acces data");
            paramKey.put("required", true);
            JSONObject paramName = new JSONObject();
            paramName.put("type", "string");
            paramName.put("description", "Distributor name for users with 'set' or 'both' permission");
            paramName.put("required", true);
            JSONObject paramNormal = new JSONObject();
            paramNormal.put("type", "double");
            paramNormal.put("description", "Normal tarif");
            paramNormal.put("units", "€/kWh");
            JSONObject paramDay = new JSONObject();
            paramDay.put("type", "double");
            paramDay.put("description", "Day tarif");
            paramDay.put("units", "€/kWh");
            JSONObject paramNight = new JSONObject();
            paramNight.put("type", "double");
            paramNight.put("description", "Night tarif");
            paramNight.put("units", "€/kWh");
            JSONObject paramGreen = new JSONObject();
            paramGreen.put("type", "double");
            paramGreen.put("description", "Green cost tarif");
            paramGreen.put("units", "€/kWh");
            JSONObject parameters = new JSONObject();
            parameters.put("key", paramKey);
            parameters.put("name", paramName);
            parameters.put("normal", paramNormal);
            parameters.put("day", paramDay);
            parameters.put("night", paramNight);
            parameters.put("green", paramGreen);

            JSONObject postmethod = new JSONObject();
            postmethod.put("description", "Add distributor to database");
            postmethod.put("parameters", parameters);
            methods.put("POST",postmethod);
            JSONObject getmethod = new JSONObject();
            getmethod.put("parameters", "ref. POST");
            getmethod.put("Example URL", "http://usermanager-167313.appspot.com/create?key=API_KEY&name=DistributorName&normal=0.01&day=0.02&night=0.03&green=0.04");
            methods.put("GET", getmethod);
            methods.put("OPTIONS", "info page");
        } catch (JSONException e) {
            e.printStackTrace();
        }
        response.getWriter().print(methods);

    }
}
