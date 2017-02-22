<label for="">Response:</label>
<div>
    <pre>
    var error = responseCode.code === 500;
    var empty = responseCode.code === 204;

    if(error) // block below is for 500 error scenario
    {
        tests["Response Error"] = error !== true;
    }
    else if(empty) // block below is for empty scenario
    {
        tests["Response Empty"] = empty === true;
    }
    else // block below is for return with payload
    {
        tests["Response time is less than 500ms"] = responseTime <  {{$response}};

        tests["Body matches string"] = responseBody.has("status");
        tests["Body matches string"] = responseBody.has("data");
        tests["Body matches string"] = responseBody.has("message");

        var schema =
        {{$result}};

        var data = JSON.parse(responseBody);
        console.log(tv4.error);
        tests["Valid Data Structure"] = tv4.validate(data, schema);

        if(data.success) // case success
        {
            tests["Status code equal 200"] = responseCode.code === 200;
        }
        else // case failed
        {
            tests["Status code is not equal to 500"] = responseCode.code !== 500;
            tests["Status code is not equal to 200"] = responseCode.code !== 200;
            tests["Error message should present"] = data.message.length > 0;
        }
    }

    </pre>
</div>

