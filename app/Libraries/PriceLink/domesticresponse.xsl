<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <xsl:choose>
            <xsl:when test="unishippersdomesticrateresponse/status != 'FAILED'">
                <xsl:for-each select="unishippersdomesticrateresponse/rates/rate">
                    <table style="width:337px;font-family: arial, helvetica;font-size: 11px;">
                        <tr>
                            <td colspan="2">Weight:<xsl:value-of select="weight"/><xsl:if test="dimweight"> (Dimensional Weight of: <xsl:value-of select="dimweight"/> lbs)</xsl:if></td>
                        </tr>
                        <xsl:if test="zone">
                            <tr>
                                <td colspan="2">Zone:<xsl:value-of select="zone"/></td>
                            </tr>
                        </xsl:if>
                        <xsl:for-each select="errors">
                            <tr>
                                <td><xsl:value-of select="error"/></td>
                            </tr>
                        </xsl:for-each>
                        <xsl:for-each select="warnings/warning">
                            <xsl:choose>

                                <xsl:when test="starts-with(.,'Charge Weight is ') and substring(.,18) != ancestor::*/weight">
                                    <tr>
                                        <td><span style="color:blue;">Due to the large size of the package, this shipment was charged the rate for a <xsl:value-of  select="substring(.,18)"/> pound package.</span></td>
                                    </tr>
                                </xsl:when>
                                <xsl:when test="starts-with(.,'Charge Weight is ')">
                                </xsl:when>
                                <xsl:when test="starts-with(.,'Since')">
                                </xsl:when>
                                <xsl:otherwise>
                                    <tr>
                                        <td><xsl:value-of  select="."/></td>
                                    </tr>
                                </xsl:otherwise>
                            </xsl:choose>
                        </xsl:for-each>
                        <tr>
                            <td colspan="2"><p>Commitment:<xsl:value-of select="commitment"/></p></td>
                        </tr>
                        <xsl:for-each select="fees/fee">
                            <tr>
                                <td><xsl:value-of select="description"/>:</td><td align="right"><xsl:value-of select="sellrate"/></td>
                            </tr>
                        </xsl:for-each>
                        <xsl:choose>
                            <xsl:when test="string(number(total)) != 'NaN' and number(total) > 0">
                                <tr>
                                    <td align="right"><b>Total:</b></td><td align="right"><span><xsl:value-of select="format-number(total, '$###,###.00')"/></span></td>
                                </tr>
                            </xsl:when>
                            <xsl:otherwise>
                                <tr>
                                    <td align="right"><b></b></td><td align="right"><span></span></td>
                                </tr>
                            </xsl:otherwise>
                        </xsl:choose>
                    </table>
                </xsl:for-each>
            </xsl:when>
            <xsl:otherwise>
                <table style="width:230px;font-family: arial, helvetica;font-size: 11px;">
                    <xsl:for-each select="unishippersdomesticrateresponse/errors">
                        <tr>
                            <td><xsl:value-of select="error"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>